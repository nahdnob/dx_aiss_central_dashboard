<?php

namespace App\Services\Sensor;

use App\Models\WorkHour;
use App\Models\PatternHistory;

class SensorContextService
{
    public function currentShift(string $time): ?int
    {
        return WorkHour::whereTime('time_start', '<=', $time)
                       ->whereTime('time_end', '>=', $time)
                       ->value('shift_id');
    }

    public function currentWorkHour(string $time): ?int
    {
        return WorkHour::whereTime('time_start', '<=', $time)
                       ->whereTime('time_end', '>=', $time)
                       ->value('id');
    }

    public function currentPattern(int $lineId): ?int
    {
        return PatternHistory::where('line_id', $lineId)->latest()->value('pattern_id');
    }

    public function shiftBoundary(int $shift): array
    {
        $first = WorkHour::where('shift_id', $shift)->orderBy('id')->first();
        $last  = WorkHour::where('shift_id', $shift)->orderBy('id','desc')->first();

        return [
            'first_start' => $first->time_start,
            'last_end'    => $last->time_end,
        ];
    }
}