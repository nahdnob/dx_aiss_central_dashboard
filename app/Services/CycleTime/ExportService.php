<?php

namespace App\Services\CycleTime;

use App\Models\SensorHistory;
use App\Models\Pattern;
use App\Models\Shift;

use Carbon\Carbon;

class ExportService
{
    public function __construct(
        protected FilterService $filterService
    ) {}

    public function getFilteredLogs($patternId, $date, $shiftId, $lineId = null)
    {
        $query = SensorHistory::with(['sensor:id,name', 'pattern:id,name'])
            ->when($lineId, fn($q) => $q->where('line_id', $lineId));

        if ($patternId) {
            $query->where('pattern_id', $patternId);
        }

        if ($date && $shiftId) {
            $query = $this->filterService->apply($query, $date, $shiftId);
        }

        return $query->orderBy('time')->get();
    }

    public function getPosMapping()
    {
        $patterns = Pattern::with('sensors')->get();

        $map = [];

        foreach ($patterns as $p) {
            foreach ($p->sensors as $s) {
                $map[$p->id][$s->id] = $s->pivot->pos;
            }
        }

        return $map;
    }

    public function streamCsv($logs, $posMapping, $date)
    {
        $filename = "CycleTime_Log_" . ($date ?? date('Y-m-d')) . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $columns = ['Waktu', 'Pattern', 'POS', 'Durasi(s)', 'Status'];

        $callback = function () use ($logs, $columns, $posMapping) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                $status = $log->status == 1 ? 'OK' : 'NG';
                $time   = $log->time ? Carbon::parse($log->time)->format('H:i:s') : '-';

                $pos = $posMapping[$log->pattern_id][$log->sensor_id] ?? '-';
                $sensorName = $pos !== '-' ? $pos : '-';

                fputcsv($file, [
                    $time,
                    $log->pattern?->name ?? '-',
                    $sensorName,
                    $log->duration,
                    $status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getPdfData($patternId, $date, $shiftId, $lineId = null)
    {
        $logs = $this->getFilteredLogs($patternId, $date, $shiftId, $lineId);
        $pattern = $patternId ? Pattern::query()->find($patternId) : null;
        $shift   = $shiftId ? Shift::query()->find($shiftId) : null;
        $posMapping = $this->getPosMapping();

        return compact('logs', 'pattern', 'shift', 'date', 'posMapping');
    }
}