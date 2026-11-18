<?php

namespace App\Services\Production;

use App\Models\Line;
use App\Models\ProductIn;
use App\Models\ProductSummary;
// use App\Models\Shift;
use App\Services\Production\SummaryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProductInService
{

    public function __construct(
        protected SummaryService $summaryService,
        protected ShiftResolver $shifts
    ) {}

    public function sync(): void {

        foreach (Line::whereNotNull('pokayoke_path')->get() as $line) {
            $this->syncLine($line);
        }
    }

    private function syncLine(Line $line): void {

        $today    = now();
        $shift    = $this->shifts->current($today);
        $lastData = ProductIn::where('line_id', $line->id)->orderByDesc('id')->first();

        $folderDate = $shift['folder_date'] ?? $today->copy();
        $filePath   = ($shift && $shift['folder'])
            ? $this->getFilePath($line, $folderDate, $shift['folder'])
            : null;

        if ($lastData === null) {

            if ($filePath === null) {
                return;
            }

            $this->processFile($line, $folderDate, $filePath);
            SyncState::markCaughtUp(SyncState::IN, $line->id);
            return;
        }

        $lastDate = Carbon::parse($lastData->time_in)->toDateString();
        $nowDate  = $today->toDateString();

        if ($lastDate !== $nowDate) {
            // Selama kalibrasi berjalan, WIP belum boleh ditutup otomatis.
            // Jika kalibrasi gagal di tengah jalan, status tetap "belum caught up".
            SyncState::markCalibrating(SyncState::IN, $line->id);
            $this->calibrate($line, $lastData, $lastDate, $nowDate);
            SyncState::markCaughtUp(SyncState::IN, $line->id);
            return;
        }

        if ($filePath === null || !file_exists($filePath)) {
            return;
        }

        $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $lastIndex = collect($data)->search(
            fn ($row) => str_contains($row, $lastData->part_id)
        );

        if ($lastIndex !== false && $lastIndex === array_key_last($data)) {
            SyncState::markCaughtUp(SyncState::IN, $line->id);
            return;
        }

        $startIndex = $lastIndex === false ? 0 : $lastIndex + 1;

        $this->processFile($line, $folderDate, $filePath, $startIndex);
        SyncState::markCaughtUp(SyncState::IN, $line->id);
    }

    private function setFilePath(Line $line, $today, string $now, ?int $shiftId): ?string {

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

    private function getFilePath(Line $line, $date, string $shift): string
    {
        return $line->pokayoke_path . '\\'
                . $date->year . '\\'
                . $date->month . '\\'
                . $date->format('d') . '\\'
                . $shift . '\\PRODUCTION DATA\\Data Scan.txt';
    }

    private function processFile(Line $line, $currentDate, string $filePath, int $startIndex = 0): void{

        if (!file_exists($filePath)) {
            return;
        }

        $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        for ($i = $startIndex; $i < count($data); $i++) {

            $parsed = $this->parseLine($data[$i]);

            if ($parsed && $parsed['judgement'] === 'OK') {

                $product = $this->save($line, $currentDate, $parsed);

                if ($product) {
                    $alreadyCovered = !$product->wasRecentlyCreated
                        && ProductSummary::where('line_id', $product->line_id)
                            ->where('first_id', '<=', $product->id)
                            ->where('last_id', '>=', $product->id)
                            ->exists();

                    if (!$alreadyCovered) {
                        try {
                            $this->summaryService->updateSummary($product);
                        } catch (\Throwable $e) {
                            Log::error('[PRODUCT-IN][SUMMARY_FAIL]', [
                                'part_id' => $product->part_id,
                                'error'   => $e->getMessage(),
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function parseLine(string $line): ?array
    {
        $cols = preg_split('/[\t\s]+/', trim($line));

        if (!isset($cols[3])) {
            return null;
        }

        if (strlen($cols[3]) < 15) {

            return [
                'timeIn'     => $cols[0]  ?? null,
                'partNumber' => $cols[3]  ?? null,
                'partId'     => $cols[10] ?? null,
                'judgement'  => $cols[12] ?? null,
            ];
        }

        return [
            'timeIn'     => $cols[0]  ?? null,
            'partNumber' => substr($cols[3], 0, 13),
            'partId'     => $cols[9]  ?? null,
            'judgement'  => $cols[11] ?? null,
        ];
    }

    private function save(Line $line, $currentDate, array $parsed, int $quantity = 2): ?ProductIn {

        if (empty($parsed['partId']) || empty($parsed['partNumber']) || empty($parsed['timeIn'])) {
            return null;
        }

        $baseDate = $currentDate->copy();
        if ($parsed['timeIn'] < $this->shifts->workdayStart()) {
            $baseDate->addDay();
        }

        $dateTimeIn = $baseDate->format('Y-m-d') . ' ' . $parsed['timeIn'];

        return ProductIn::firstOrCreate(
            [
                'line_id' => $line->id,
                'part_id' => $parsed['partId'],
            ],
            [
                'part_number' => $parsed['partNumber'],
                'time_in'     => $dateTimeIn,
                'quantity'    => $quantity,
            ]
        );
    }

    private function calibrate(Line $line, $lastData, string $lastDate, string $nowDate): int {

        $count    = 0;
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
                $count++;
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
