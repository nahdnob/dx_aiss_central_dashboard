<?php

namespace App\Services\Production;

use App\Models\Line;
use App\Models\ProductIn;
use App\Models\Shift;
use App\Services\Production\SummaryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProductInService
{

    public function __construct(
        protected SummaryService $summaryService
    ) {}

    public function sync(): void {

        foreach (Line::whereNotNull('pokayoke_path')->get() as $line) {
            $this->syncLine($line);
        }
    }

    private function syncLine(Line $line): void {

        $today    = now();
        $now      = $today->format('H:i:s');
        $lastData = ProductIn::where('line_id', $line->id)->latest()->first();

        if ($lastData === null) {

            $shiftId  = $this->getShiftId($now);
            $filePath = $this->setFilePath($line, $today, $now, $shiftId);

            $this->processFile($line, $today, $filePath);
            return;
        }

        $lastDate = Carbon::parse($lastData->time_in)->toDateString();
        $nowDate  = $today->toDateString();

        if ($lastDate !== $nowDate) {
            $this->calibrate($line, $lastData, $lastDate, $nowDate);
            return;
        }

        $shiftId  = $this->getShiftId($now);
        $filePath = $this->setFilePath($line, $today, $now, $shiftId);

        try {

            $data = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        } catch (\Throwable $e) {

            Log::error($e->getMessage());
            return;
        }

        $lastIndex = collect($data)->search(
            fn ($row) => str_contains($row, $lastData->part_id)
        );

        if ($lastIndex === false || $lastIndex === array_key_last($data)) {
            return;
        }

        $this->processFile($line, $today, $filePath, $lastIndex + 1);
    }

    private function setFilePath(Line $line, $today, string $now, int $shiftId): ?string {

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

        $updatedParts = [];

        for ($i = $startIndex; $i < count($data); $i++) {

            $parsed = $this->parseLine($data[$i]);

            if ($parsed && $parsed['judgement'] === 'OK') {

                $product = $this->save($line, $currentDate, $parsed);

                if ($product) {
                    $updatedParts[] = $product->part_number;
                }
            }
        }

        // update summary hanya sekali per part_number
        foreach (array_unique($updatedParts) as $partNumber) {
            $this->summaryService->updateSummary($line->id, $partNumber);
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
        $timeOnly = Carbon::createFromFormat('H:i:s', $parsed['timeIn']);

        if ($timeOnly->lt(Carbon::createFromTime(7, 30))) {
            $baseDate->addDay();
        }

        $dateTimeIn = $baseDate->format('Y-m-d') . ' ' . $parsed['timeIn'];

        return ProductIn::firstOrCreate(
            [
                'part_id'     => $parsed['partId'],
                'part_number' => $parsed['partNumber'],
                'time_in'     => $dateTimeIn,
            ],
            [
                'quantity' => $quantity,
                'line_id'  => $line->id,
            ]
        );
    }

    private function calibrate(Line $line, $lastData, string $lastDate, string $nowDate): void {

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
}
