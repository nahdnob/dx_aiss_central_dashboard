<?php

namespace App\Services\Production;

use App\Models\Line;
use App\Models\ProductOut;
use App\Models\ProductIn;
use App\Models\Shift;

use App\Services\Production\FifoService;
use App\Services\Production\SummaryService;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProductOutService
{
    public function __construct(
        private FifoService $fifoService,
        private SummaryService $summaryService
    ) {}

    public function sync(): int {

        $lock = Cache::lock('product-out-sync', 300);

        if (!$lock->get()) {
            Log::warning('[PRODUCT-OUT][LOCKED]');
            return 0;
        }

        try {

            $count = 0;

            foreach (Line::whereNotNull('kanban_path')->get() as $line) {
                $count += $this->syncLine($line);
            }

            return $count;

        } finally {

            $lock->release();
        }
    }

    private function syncLine(Line $line): int {

        Log::info('[PRODUCT-OUT][SYNC_START]', ['line_id' => $line->id]);

        $today    = now();
        $now      = $today->format('H:i:s');
        $lastData = ProductOut::where('line_id', $line->id)->latest()->first();

        if ($lastData === null) {

            $shiftId  = $this->getShiftId($now);
            $filePath = $this->setFilePath($line, $today, $now, $shiftId);

            if (!$filePath) {
                Log::warning('[PRODUCT-OUT][FILE_PATH_NULL]', [
                    'line_id'  => $line->id,
                    'shift_id' => $shiftId,
                    'time'     => $now
                ]);
                return 0;
            }

            $count = $this->processFile($line, $today, $filePath);

            Log::info('[PRODUCT-OUT][SYNC_END]', [
                'line_id'   => $line->id,
                'processed' => $count,
                'mode'      => 'initial'
            ]);

            return $count;
        }

        $lastDate = Carbon::parse($lastData->time_out)->toDateString();
        $nowDate  = $today->toDateString();

        if ($lastDate !== $nowDate) {

            $count = $this->calibrate($line, $lastData, $lastDate, $nowDate);

            Log::info('[PRODUCT-OUT][SYNC_END]', [
                'line_id'   => $line->id,
                'processed' => $count,
                'mode'      => 'calibration'
            ]);

            return $count;
        }

        $shiftId  = $this->getShiftId($now);
        $filePath = $this->setFilePath($line, $today, $now, $shiftId);

        if (!$filePath) {
            Log::warning('[PRODUCT-OUT][FILE_PATH_NULL]', [
                'line_id'  => $line->id,
                'shift_id' => $shiftId,
                'time'     => $now
            ]);
            return 0;
        }

        try {

            $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        } catch (\Throwable $e) {

            Log::error($e->getMessage());
            return 0;
        }

        $lastIndex = collect($data)->search(
            fn ($row) => str_contains($row, $lastData->tag_id)
        );

        if ($lastIndex === false || $lastIndex === array_key_last($data)) {
            Log::info('[PRODUCT-OUT][NO_NEW_DATA]', ['line_id' => $line->id]);
            return 0;
        }

        $count = $this->processFile($line, $today, $filePath, $lastIndex + 1);

        Log::info('[PRODUCT-OUT][SYNC_END]', [
            'line_id'   => $line->id,
            'processed' => $count
        ]);

        return $count;
    }

    private function setFilePath(Line $line, $today, string $now, int $shiftId): ?string
    {
        if ($shiftId === 1) {

            return $this->getFilePath($line, $today, 'DAY');
        }

        if ($shiftId === 2) {

            if ($now >= '20:00:00') {
                return $this->getFilePath($line, $today, 'NIGHT');
            }

            if ($now < '07:30:00') {
                return $this->getFilePath($line, $today->copy()->subDay(), 'NIGHT');
            }
        }
        return null;
    }

    private function getFilePath(Line $line, $date, string $shift): string {

        return $line->kanban_path . '\\'
                . $date->year . '\\'
                . $date->month . '\\'
                . $date->format('d') . '\\'
                . $shift . '\\KANBAN DATA\\Data.txt';
    }

    private function processFile(Line $line, $currentDate, string $filePath, int $startIndex = 0): int {

        if (!file_exists($filePath)) {

            Log::warning('[PRODUCT-OUT][FILE_NOT_FOUND]', [
                'line_id' => $line->id,
                'path'    => $filePath
            ]);

            return 0;
        }

        try {
            $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        } catch (\Throwable $e) {

            Log::error('[PRODUCT-OUT][READ_FILE_ERROR]', [
                'line_id' => $line->id,
                'message' => $e->getMessage()
            ]);

            return 0;
        }

        $count = 0;
        $updatedParts = [];

        for ($i = $startIndex; $i < count($data); $i++) {

            $parsed = $this->parseLine($data[$i]);

            if (!$parsed) {
                continue;
            }

            if ($parsed['judgement'] === 'OK') {

                if ($this->save($line, $currentDate, $parsed)) {
                    $count++;
                    $updatedParts[] = $parsed['partNumber'];
                }
            }
        }

        // update summary hanya sekali per part_number
        foreach (array_unique($updatedParts) as $partNumber) {
            $this->summaryService->updateSummary($line->id, $partNumber);
        }

        return $count;
    }

    private function parseLine(string $line): ?array {

        $cols = preg_split('/[\t\s]+/', trim($line));

        if (!isset($cols[14])) {
            return null;
        }

        $timeOut = str_replace('.', ':', $cols[0] ?? '');

        return [
            'timeOut'    => $timeOut,
            'quantity'   => $cols[6]  ?? null,
            'partNumber' => isset($cols[9]) ? substr($cols[9], 0, 13) : null,
            'tagId'      => $cols[14] ?? null,
            'judgement'  => $cols[17] ?? null,
        ];
    }

    private function save(Line $line, $currentDate, array $parsed): bool
    {
        if (empty($parsed['tagId']) || empty($parsed['partNumber']) || empty($parsed['timeOut'])) {
            return false;
        }

        $parsed['timeOut'] = date('H:i:s', strtotime($parsed['timeOut']));

        $baseDate = $currentDate->copy();
        $timeOnly = Carbon::createFromFormat('H:i:s', $parsed['timeOut']);

        if ($timeOnly->lt(Carbon::createFromTime(7, 30))) {
            $baseDate->addDay();
        }

        $dateTimeOut = $baseDate->format('Y-m-d') . ' ' . $parsed['timeOut'];

        $productOut = ProductOut::firstOrCreate(
            [
                'tag_id' => $parsed['tagId'],
            ],
            [
                'part_number' => $parsed['partNumber'],
                'time_out'    => $dateTimeOut,
                'quantity'    => (int) $parsed['quantity'],
                'line_id'     => $line->id,
            ]
        );

        if (!$productOut->wasRecentlyCreated) {
            return false;
        }

        // FIFO sementara tetap di sini
        $this->fifoService->process($productOut);

        return true;
    }

    private function calibrate(Line $line, $lastData, string $lastDate, string $nowDate): int {

        $count = 0;

        $currentDate = Carbon::parse($lastDate)->startOfDay();
        $endDate     = Carbon::parse($nowDate)->startOfDay();
        $shifts      = ['DAY', 'NIGHT'];

        while ($currentDate->lte($endDate)) {

            foreach ($shifts as $shift) {

                $filePath = $this->getFilePath($line, $currentDate, $shift);

                if (!file_exists($filePath)) {
                    continue;
                }

                $startIndex = 0;

                if ($currentDate->toDateString() === $lastDate) {

                    $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                    $foundIndex = collect($data)->search(
                        fn ($row) => str_contains($row, $lastData->tag_id)
                    );

                    $startIndex = ($foundIndex !== false) ? $foundIndex + 1 : 0;
                }

                $count += $this->processFile($line, $currentDate, $filePath, $startIndex);
            }

            $currentDate->addDay();
        }

        return $count;
    }


    private function getShiftId(string $time): ?int {

        return Shift::where(function ($q) use ($time) {

            $q->where('time_start', '<=', $time, 'and')->where('time_end', '>', $time, 'and');

        }, null, null, 'and')->value('id');
    }
}
