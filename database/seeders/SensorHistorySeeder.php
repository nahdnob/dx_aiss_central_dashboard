<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SensorHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Generates 30 sensor history entries per sensor_summary row.
     * Duration is randomised around the pattern's cycle_time.
     * Status is true (OK) if duration is within [min_time, max_time].
     */
    public function run(): void
    {
        $now         = Carbon::now();
        $today       = Carbon::today();
        $perSummary  = 30;   // history entries per summary
        $batchData   = [];

        $summaries = DB::table('sensor_summaries')->get();

        foreach ($summaries as $summary) {
            $workHour = DB::table('work_hours')->where('id', $summary->work_hour_id)->first();
            $pattern  = DB::table('patterns')->where('id', $summary->pattern_id)->first();

            // Build a start datetime (use today's date + work hour time_start)
            $timeStart   = Carbon::parse($today->format('Y-m-d') . ' ' . $workHour->time_start);
            $currentTime = $timeStart->copy();

            for ($i = 0; $i < $perSummary; $i++) {
                // Variance ±10 s from cycle_time
                $variance = rand(-100, 100) / 10;
                $duration = round($pattern->cycle_time + $variance, 2);
                $duration = max(1.0, $duration); // guard against negatives

                $isNG = ($duration > $pattern->max_time || $duration < $pattern->min_time);

                $batchData[] = [
                    'line_id'           => $summary->line_id,
                    'sensor_summary_id' => $summary->id,
                    'pattern_id'        => $summary->pattern_id,
                    'sensor_id'         => $summary->sensor_id,
                    'time'              => $currentTime->format('Y-m-d H:i:s'),
                    'duration'          => $duration,
                    'reason'            => $isNG ? 'Cycle time out of range' : null,
                    'status'            => !$isNG,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];

                // Advance time pointer by the cycle duration
                $currentTime->addSeconds((int) $duration);
            }
        }

        // Insert in chunks of 500 to avoid memory issues
        foreach (array_chunk($batchData, 500) as $chunk) {
            DB::table('sensor_histories')->insert($chunk);
        }
    }
}
