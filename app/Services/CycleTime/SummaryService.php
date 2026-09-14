<?php

namespace App\Services\CycleTime;

use App\Models\SensorSummary;
use App\Models\SensorHistory;
use Carbon\Carbon;

class SummaryService
{
    public function getScatterData($query)
    {
        return $query->orderBy('time')
            ->get()
            ->map(fn($h) => [
                'x'      => $h->time ? Carbon::parse($h->time)->format('H:i:s') : null,
                'y'      => (float) $h->duration,
                'status' => $h->status,
                'sensor' => $h->sensor?->name,
            ]);
    }

    public function getSummaryData($query, $sensors)
    {
        $sensorNames = $sensors->pluck('name', 'id');

        return $query->get()
            ->groupBy('sensor_id')
            ->map(function ($rows) use ($sensorNames) {

                $sensorId   = $rows->first()->sensor_id;
                $sensorName = $sensorNames[$sensorId] ?? 'Unknown';

                $jamData = [];

                foreach ($rows as $row) {
                    $jamIndex = $row->workHour
                        ? $row->workHour->hour_number
                        : $row->work_hour_id;

                    $jamData[$jamIndex] = [
                        'max' => round($row->maximal, 2),
                        'avg' => round($row->average, 2),
                        'min' => round($row->minimal, 2),
                    ];
                }

                return [
                    'sensor_name' => $sensorName,
                    'jam'         => $jamData,
                ];
            })->values();
    }
}