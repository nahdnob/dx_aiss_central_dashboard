<?php

use Carbon\Carbon;

function production_date(Carbon $now): string
{
    return $now->format('H:i:s') < '07:30:00'
            ? $now->copy()->subDay()->toDateString()
            : $now->toDateString();
}

function calculate_duration(bool $halveDuration, string $t1, string $t2): int
{
    $start = Carbon::parse($t1);
    $end   = Carbon::parse($t2);

    if ($end->lessThan($start)) {
        [$start, $end] = [$end, $start];
    }

    $diff = $start->diffInSeconds($end);

    return $halveDuration ? intval($diff / 2) : $diff;
}

