<?php

namespace App\Services\Sensor;

use App\Models\Line;
use App\Models\Pattern;
use App\Models\SensorHistory;
use App\Models\SensorSummary;

use App\Services\Sensor\SensorContextService;
use App\Services\Sensor\SensorLimitService;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CompletingDataService
{
    public function __construct(
        private SensorContextService $context,
        private SensorLimitService $limit
    ) {}

    public function run(): void
    {
        $now  = now();
        $time = $now->format('H:i:s');
        $date = production_date($now);

        $shift    = $this->context->currentShift($time);
        $workHour = $this->context->currentWorkHour($time);

        if (!$shift || !$workHour) {
            Log::warning('[SENSOR][SKIP_CONTEXT]', compact('shift', 'workHour'));
            return;
        }

        $hour = $this->context->shiftBoundary($shift);

        foreach (Line::all() as $line) {
            $this->processLine($line->id, $date, $hour, $workHour);
        }
    }

    private function processLine(int $lineId, string $date, array $hour, int $workHour): void
    {
        $patternId = $this->context->currentPattern($lineId);

        if (!$patternId) {
            Log::warning('[SENSOR][SKIP_CONTEXT]', ['line_id' => $lineId, 'reason' => 'no_active_pattern']);
            return;
        }

        $limit = $this->limit->get($patternId);

        $sensors = Pattern::findOrFail($patternId, ['*'])->sensors;

        foreach ($sensors as $sensor) {

            // 1️⃣ Sensor Summary
            $summaryId = SensorSummary::whereBetween(
                    'created_at',
                    [$date.' '.$hour['first_start'], $date.' '.$hour['last_end']],
                    'and',
                    false
                )
                ->where([
                    'work_hour_id' => $workHour,
                    'pattern_id'   => $patternId,
                    'sensor_id'    => $sensor->id,
                    'line_id'      => $lineId,
                ])
                ->value('id');

            // 2️⃣ Ambil data belum diproses
            $histories = SensorHistory::where('sensor_id', '=', $sensor->id, 'and')
                                      ->where('line_id', $lineId)
                                      ->whereBetween('time', [
                                          $date.' '.$hour['first_start'],
                                          $date.' '.$hour['last_end'],
                                      ], 'and', false)
                                      ->orderBy('time', 'asc')
                                      ->get();

            if ($histories->count() < 2) {
                continue;
            }

            // 3️⃣ Hitung durasi per record
            for ($i = 1; $i < $histories->count(); $i++) {

                // SKIP jika sudah dihitung
                if (!is_null($histories[$i]->duration)) {
                    continue;
                }

                $prev = Carbon::parse($histories[$i - 1]->time);
                $curr = Carbon::parse($histories[$i]->time);

                $diff = $prev->diffInSeconds($curr);

                // Proteksi gap
                $cycle = (int) $sensor->pivot->cycle;

                if ($diff > ($limit['ucl'] * $cycle * 3)) {
                    continue;
                }

                $duration = $diff / $cycle;

                $status = ($duration < $limit['lcl'] || $duration > $limit['ucl']) ? 0 : 1;

                $histories[$i]->update([
                    'sensor_summary_id' => $summaryId,
                    'pattern_id'        => $patternId,
                    'duration'          => $duration,
                    'status'            => $status,
                ]);

                Log::info('[SENSOR][UPDATED]', [
                    'line_id'    => $lineId,
                    'sensor_id'  => $sensor->id,
                    'history_id' => $histories[$i]->id,
                    'duration'   => $duration,
                    'cycle'      => $cycle,
                    'status'     => $status,
                ]);
            }
        }
    }
}
