<?php

namespace App\Services\CycleTime;

use App\Models\SensorSummary;
use Carbon\Carbon;

class RealtimeService
{
    public function getTodaySummary($patternId, $lineId = null)
    {
        return SensorSummary::with('sensor:id,name', 'workHour:id,hour_number,time_start,time_end')
            ->whereDate('created_at', Carbon::today())
            ->when($lineId, fn($q) => $q->where('line_id', $lineId))
            ->when($patternId, fn($q) => $q->where('pattern_id', $patternId))
            ->orderBy('work_hour_id')
            ->orderBy('sensor_id')
            ->get();
    }

    public function calculateRealtime($pattern, $summary)
    {
        if (!$pattern) return [];

        return $pattern->sensors->map(function ($sensor) use ($summary) {

            $valid = $summary->where('sensor_id', $sensor->id)
                ->pluck('average')
                ->filter(fn($v) => !is_null($v) && $v > 0);

            return [
                'sensor_id'   => $sensor->id,
                'sensor_name' => $sensor->name,
                'duration'    => $valid->isNotEmpty() ? round($valid->avg(), 2) : 0,
                'time'        => now()->format('H:i:s'),
            ];
        })->values();
    }
}