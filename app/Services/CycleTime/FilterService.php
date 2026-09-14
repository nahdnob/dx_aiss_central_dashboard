<?php

namespace App\Services\CycleTime;

use App\Models\Shift;
use App\Models\SensorHistory;
use Carbon\Carbon;

class FilterService
{
    public function resolve($patternId, $filterDate, $filterShiftId)
    {
        $shifts = Shift::all();

        if ($filterDate && $filterShiftId) {
            return [$filterDate, $filterShiftId, $shifts];
        }

        $latest = SensorHistory::where('pattern_id', $patternId)
            ->latest('time')
            ->first();

        if ($latest && $latest->time) {
            $time = Carbon::parse($latest->time);
            $timeStr = $time->format('H:i:s');
            $date = $time->format('Y-m-d');

            foreach ($shifts as $s) {
                if ($this->isInShift($timeStr, $s)) {
                    return [$date, $s->id, $shifts];
                }
            }
        }

        return [
            Carbon::today()->format('Y-m-d'),
            $shifts->first()?->id,
            $shifts
        ];
    }

    private function isInShift($time, $shift)
    {
        $start = $shift->time_start;
        $end   = $shift->time_end;

        if ($start <= $end) {
            return $time >= $start && $time <= $end;
        }

        return $time >= $start || $time <= $end;
    }

    public function apply($query, $date, $shiftId, $column = 'time')
    {
        $shift = Shift::find($shiftId);
        if (!$shift) return $query;

        $start = Carbon::parse("$date $shift->time_start");
        $end   = Carbon::parse("$date $shift->time_end");

        if ($end->lessThan($start)) {
            $end->addDay();
        }

        return $query->whereBetween($column, [$start, $end]);
    }
}