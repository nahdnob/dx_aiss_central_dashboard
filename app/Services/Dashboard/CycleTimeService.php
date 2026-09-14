<?php

namespace App\Services\Dashboard;

use App\Models\Sensor;
use App\Models\SensorSummary;
use App\Models\Pattern;

use App\Services\Sensor\SensorContextService;

class CycleTimeService
{
    public function __construct(
        private SensorContextService $context
    ) {}

    public function get(int $lineId){
        $sensors = Sensor::where('line_id', $lineId)->select('id','name')->get();
        $date    = production_date(now());
        $hour    = $this->context->shiftBoundary($this->context->currentShift(now()->format('H:i:s')));
        $maxY    = Pattern::where('id', $this->context->currentPattern($lineId))->value('max_time');

        // Cek apakah ada data pada hari & shift ini
        $hasData = SensorSummary::where('line_id', $lineId)->whereBetween('created_at', [$date . ' ' . $hour['first_start'], $date . ' ' . $hour['last_end']])->exists();

        // Jika belum ada data, ambil tanggal & shift dari data terakhir yang tersedia
        if (!$hasData) {
            $latest = SensorSummary::where('line_id', $lineId)->latest('created_at')->first();
            if ($latest) {
                $latestDate = \Carbon\Carbon::parse($latest->created_at);
                $date       = production_date($latestDate);
                $hour       = $this->context->shiftBoundary($this->context->currentShift($latestDate->format('H:i:s')));
            }
        }

        foreach ($sensors as $sensor) {

            $sensorQuery = SensorSummary::where('line_id', $lineId)
                                        ->whereBetween('created_at', [$date . ' ' . $hour['first_start'], $date . ' ' . $hour['last_end']])
                                        ->where('sensor_id', $sensor->id);
            if ($sensorQuery->exists()) {
                $name[]    = strtoupper($sensor->name);
                $average[] = $sensorQuery->avg('average');
                $max[]     = $sensorQuery->max('maximal');
                $min[]     = $sensorQuery->min('minimal');
            }
        }
        
        $results = [
            'sensor'  => $name    ?? [],
            'average' => $average ?? [],
            'max'     => $max     ?? [],
            'min'     => $min     ?? [],
            'maxY'    => $maxY    ?? 100
        ];
        
        return $results;
    }
}