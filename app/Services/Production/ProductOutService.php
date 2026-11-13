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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ProductOutService
{
    public function __construct(
        private FifoService $fifoService,
        private SummaryService $summaryService,
        private ShiftResolver $shifts
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
                $this->retryUnallocated($line);
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
        $now      = $today->format('H:i:s');   // masih dipakai di log FILE_PATH_NULL
        $shift    = $this->shifts->current($today);
        $lastData = ProductOut::where('line_id', $line->id)->orderByDesc('id')->first();

        $folderDate = $shift['folder_date'] ?? $today->copy();
        $filePath   = ($shift && $shift['folder'])
            ? $this->getFilePath($line, $folderDate, $shift['folder'])
            : null;

        if ($lastData === null) {

            if (!$filePath) {
                Log::warning('[PRODUCT-OUT][FILE_PATH_NULL]', ['line_id' => $line->id, 'shift_id' => $shift['id'] ?? null, 'time' => $now]);
                return 0;
            }

            $count = $this->processFile($line, $folderDate, $filePath);
            Log::info('[PRODUCT-OUT][SYNC_END]', ['line_id' => $line->id, 'processed' => $count, 'mode' => 'initial']);
            return $count;
        }

        $lastDate = Carbon::parse($lastData->time_out)->toDateString();
        $nowDate  = $today->toDateString();

        if ($lastDate !== $nowDate) {
            $count = $this->calibrate($line, $lastData, $lastDate, $nowDate);
            Log::info('[PRODUCT-OUT][SYNC_END]', ['line_id' => $line->id, 'processed' => $count, 'mode' => 'calibration']);
            return $count;
        }

        if (!$filePath || !file_exists($filePath)) {
            Log::warning('[PRODUCT-OUT][FILE_PATH_NULL]', ['line_id' => $line->id, 'shift_id' => $shift['id'] ?? null, 'time' => $now]);
            return 0;
        }

        $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $lastIndex = collect($data)->search(
            fn ($row) => str_contains($row, $lastData->tag_id)
        );

        if ($lastIndex !== false && $lastIndex === array_key_last($data)) {
            Log::info('[PRODUCT-OUT][NO_NEW_DATA]', ['line_id' => $line->id]);
            return 0;
        }

        $startIndex = $lastIndex === false ? 0 : $lastIndex + 1;

        $count = $this->processFile($line, $folderDate, $filePath, $startIndex);

        Log::info('[PRODUCT-OUT][SYNC_END]', ['line_id' => $line->id, 'processed' => $count]);

        return $count;
    }

    private function setFilePath(Line $line, $today, string $now, ?int $shiftId): ?string
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
        $affected = collect();

        try {
            for ($i = $startIndex; $i < count($data); $i++) {

                $parsed = $this->parseLine($data[$i]);

                if (!$parsed || $parsed['judgement'] !== 'OK') {
                    continue;
                }

                $changed = $this->save($line, $currentDate, $parsed);

                if ($changed !== null) {
                    $count++;
                    $affected = $affected->merge($changed);
                }
            }
        } finally {
            foreach ($affected->unique('id')->sortBy('id') as $in) {
                try {
                    $this->summaryService->updateSummary($in);
                } catch (\Throwable $e) {
                    Log::error('[PRODUCT-OUT][SUMMARY_FAIL]', [
                        'product_in_id' => $in->id,
                        'error'         => $e->getMessage(),
                    ]);
                }
            }
        }

        return $count;
    }

    private function parseLine(string $line): ?array {

        $cols = preg_split('/\s+/', trim($line));
        $n    = count($cols);

        if ($n < 15) {
            return null;
        }

        $timeOut = str_replace('.', ':', $cols[0] ?? '');

        return [
            'timeOut'    => $timeOut,
            'quantity'   => $cols[6] ?? null,
            'partNumber' => substr($cols[$n - 3], 0, 13),   // JK039100-2720 / JK039100-22400Y
            'tagId'      => $cols[$n - 4],                  // 00000D510...
            'judgement'   => $cols[$n - 1],                 // OK
        ];
    }

    private function save(Line $line, $currentDate, array $parsed): ?Collection
    {
        if (empty($parsed['tagId']) || empty($parsed['partNumber']) || empty($parsed['timeOut'])) {
            return null;
        }

        $parsed['timeOut'] = date('H:i:s', strtotime($parsed['timeOut']));

        $baseDate = $currentDate->copy();

        if ($parsed['timeOut'] < $this->shifts->workdayStart()) {
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
            return null;
        }

        return $this->fifoService->process($productOut);
    }

    private function calibrate(Line $line, $lastData, string $lastDate, string $nowDate): void {

        $lastTime = Carbon::parse($lastData->time_in)->format('H:i:s');

        $lastFolderDate = $lastTime < $this->shifts->workdayStart()
            ? Carbon::parse($lastDate)->subDay()->toDateString()
            : $lastDate;

        $currentDate = Carbon::parse($lastFolderDate)->startOfDay();
        $endDate     = Carbon::parse($nowDate)->startOfDay();
        $shifts      = ['DAY', 'NIGHT'];

        while ($currentDate->lte($endDate)) {

            foreach ($shifts as $shift) {

                $filePath = $this->getFilePath($line, $currentDate, $shift);

                if (!file_exists($filePath)) {
                    continue;
                }

                $startIndex = 0;

                if ($currentDate->toDateString() === $lastFolderDate) {

                    $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                    $foundIndex = collect($data)->search(
                        fn ($row) => str_contains($row, $lastData->part_id)
                    );

                    $startIndex = ($foundIndex !== false) ? $foundIndex + 1 : 0;
                }

                $this->processFile($line, $currentDate, $filePath, $startIndex);
            }

            $currentDate->addDay();
        }
    }


    private function getShiftId(string $time): ?int {

        return Shift::where(function ($q) use ($time) {

            $q->where('time_start', '<=', $time, 'and')->where('time_end', '>', $time, 'and');

        }, null, null, 'and')->value('id');
    }

    private function retryUnallocated(Line $line): void
    {
        ProductOut::where('line_id', $line->id)
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))->from('product_ins')
                ->whereColumn('product_ins.product_out_id', 'product_outs.id');
            })
            ->orderBy('time_out')
            ->orderBy('id')
            ->each(function ($out) {
                $ins = $this->fifoService->process($out);

                foreach ($ins->sortBy('id') as $in) {
                    try {
                        $this->summaryService->updateSummary($in);
                    } catch (\Throwable $e) {
                        Log::error('[PRODUCT-OUT][RETRY_SUMMARY_FAIL]', [
                            'product_in_id' => $in->id,
                            'error'         => $e->getMessage(),
                        ]);
                    }
                }
            });
    }
}
