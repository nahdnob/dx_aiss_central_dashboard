<?php

namespace App\Services\Context;

use App\Models\WorkHour;

use Carbon\Carbon;

class ShiftContext
{
    public function get(Carbon $time): ?int {
        
        $currentTime = $time->format('H:i:s');

        return WorkHour::all()->first(function ($workHour) use ($currentTime) {

            if ($workHour->start_time <= $workHour->end_time) {
                return $currentTime >= $workHour->start_time
                    && $currentTime <= $workHour->end_time;
            }

            // shift melewati tengah malam
            return $currentTime >= $workHour->start_time
                || $currentTime <= $workHour->end_time;

        })?->shift_id;
    }
}
