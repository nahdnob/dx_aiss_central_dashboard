<?php

namespace App\Services\CycleTime;

use App\Models\SensorHistory;
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
                'pos'         => (int) $sensor->pivot->pos,
                'label'       => 'POS ' . $sensor->pivot->pos,
                'duration'    => $valid->isNotEmpty() ? round($valid->avg(), 2) : 0,
                'time'        => now()->format('H:i:s'),
            ];
        })->sortBy('pos')->values();
    }

    /**
     * Log pembacaan sensor terbaru + jumlah entri pada hari produksi berjalan (shift 1 + shift 2).
     */
    public function getRecentActivity($pattern, $lineId, int $limit = 5): array
    {
        $start = Carbon::parse(production_date(now()) . ' 07:30:00');
        $end   = $start->copy()->addDay();

        $query = SensorHistory::where('line_id', $lineId)
            ->when($pattern, fn ($q) => $q->where('pattern_id', $pattern->id))
            ->whereBetween('time', [$start, $end])
            ->aboveExceptTime();

        $posLabels = $pattern?->posLabels() ?? [];

        $logs = (clone $query)
            ->with('sensor:id,name')
            ->latest('time')
            ->limit($limit)
            ->get()
            ->each(fn ($log) => $log->pos_label = $posLabels[$log->sensor_id] ?? $log->sensor?->name);

        return [
            'logs'  => $logs,
            'total' => $query->count(),
        ];
    }
}