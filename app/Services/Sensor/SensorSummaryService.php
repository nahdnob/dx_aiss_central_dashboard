<?php

namespace App\Services\Sensor;

use App\Models\Line;
use App\Models\SensorSummary;
use App\Models\SensorHistory;
use App\Models\WorkHour;
use App\Models\Pattern;

use App\Services\Sensor\SensorContextService;
use Carbon\Carbon;

class SensorSummaryService
{
    public function __construct(
        private SensorContextService $context
    ) {}

    public function run(): void {

        // Cek jam saat ini
        $now  = Carbon::now()->format('H:i:s');

        // Cek tanggal hari ini
        $date = now()->format('Y-m-d');

        // Cek shift yang berjalan
        $shift = $this->context->currentShift($now);

        // Cek work hours yang berjalan
        $workHour = $this->context->currentWorkHour($now);

        if (!$shift || !$workHour) {
            return;
        }

        $first = WorkHour::where('shift_id', '=', $shift, 'and')->orderBy('id', 'asc')->first();
        $last  = WorkHour::where('shift_id', '=', $shift, 'and')->orderBy('id', 'desc')->first();

        $hour = [
            'first_id'   => $first->id,
            'first_start'=> $first->time_start,
            'first_end'  => $first->time_end,
            'last_id'    => $last->id,
            'last_start' => $last->time_start,
            'last_end'   => $last->time_end,
        ];

        foreach (Line::all() as $line) {
            $this->summarizeLine($line->id, $date, $hour, $workHour);
        }
    }

    private function summarizeLine(int $lineId, string $date, array $hour, int $workHour): void
    {
        // Cek pattern yang berjalan untuk line ini
        $pattern = $this->context->currentPattern($lineId);

        if (!$pattern) {
            return;
        }

        $sensors = Pattern::find($pattern, ['*'])->sensors;

        foreach ($sensors as $sensor) {

            $summary = SensorSummary::select(['id','work_hour_id', 'pattern_id', 'sensor_id', 'line_id', 'average', 'maximal', 'minimal'])
                                    ->whereBetween('created_at', [$date . ' ' . $hour['first_start'], $date . ' ' . $hour['last_end']], 'and', false)
                                    ->where('work_hour_id', '=', $workHour, 'and')
                                    ->where('pattern_id', '=', $pattern, 'and')
                                    ->where('sensor_id', '=', $sensor->id, 'and')
                                    ->where('line_id', '=', $lineId, 'and')
                                    ->first();

            if (!$summary) {

                SensorSummary::create(
                    [
                        'work_hour_id' => $workHour,
                        'pattern_id'   => $pattern,
                        'sensor_id'    => $sensor->id,
                        'line_id'      => $lineId,
                        'average'      => null,
                        'maximal'      => null,
                        'minimal'      => null
                    ]
                );
            } else {

                $summaryId = $summary->id;

                $datas = SensorHistory::whereBetween('time', [$date . ' ' . $hour['first_start'], $date . ' ' . $hour['last_end']], 'and', false)
                                      ->where('sensor_summary_id', '=', $summaryId, 'and')
                                      ->where('status', '=', 1, 'and')
                                      ->pluck('duration');

                $dataAvg = $datas->avg();
                $dataMax = $datas->max();
                $dataMin = $datas->min();

                $summary->update([
                    'average'      => $dataAvg,
                    'maximal'      => $dataMax,
                    'minimal'      => $dataMin
                ]);
            }
        }
    }
}
