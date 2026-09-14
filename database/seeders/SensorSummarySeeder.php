<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SensorSummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Generates sensor summaries for:
     *  - Pattern 1 (3MP) → sensors 1,2,3   → work_hours 1–6  (Shift Pagi)
     *  - Pattern 2 (4MP) → sensors 1,2,3,4 → work_hours 12–15 (Shift Malam)
     *  - Pattern 3 (5MP) → sensors 1–5     → work_hours 7–9  (Shift Pagi lanjutan)
     */
    public function run(): void
    {
        $now  = Carbon::now();
        $data = [];

        // ──────────────────────────────────────────────
        // Pattern 1 (3MP) · cycle_time ≈ 39.5s · max 49.5 · min 29.5
        // Sensors: 1, 2, 3 · Work hours: 1–6 (Shift Pagi)
        // ──────────────────────────────────────────────
        foreach (range(1, 6) as $whId) {
            foreach ([1, 2, 3] as $sensorId) {
                $avg    = round(37 + (rand(-30, 30) / 10), 2);   // ~34–40 s
                $data[] = [
                    'line_id'      => 2,
                    'work_hour_id' => $whId,
                    'pattern_id'   => 1,
                    'sensor_id'    => $sensorId,
                    'average'      => $avg,
                    'maximal'      => round($avg + rand(4, 9), 2),
                    'minimal'      => round($avg - rand(4, 9), 2),
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }

        // ──────────────────────────────────────────────
        // Pattern 2 (4MP) · cycle_time ≈ 27.5s · max 37.5 · min 17.5
        // Sensors: 1, 2, 3, 4 · Work hours: 12–15 (Shift Malam)
        // ──────────────────────────────────────────────
        foreach (range(12, 15) as $whId) {
            foreach ([1, 2, 3, 4] as $sensorId) {
                $avg    = round(26 + (rand(-25, 25) / 10), 2);   // ~23.5–28.5 s
                $data[] = [
                    'line_id'      => 2,
                    'work_hour_id' => $whId,
                    'pattern_id'   => 2,
                    'sensor_id'    => $sensorId,
                    'average'      => $avg,
                    'maximal'      => round($avg + rand(3, 8), 2),
                    'minimal'      => round($avg - rand(3, 8), 2),
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }

        // ──────────────────────────────────────────────
        // Pattern 3 (5MP) · cycle_time ≈ 25s · max 35 · min 35
        // Sensors: 1–5 · Work hours: 7–9 (Shift Pagi lanjutan)
        // ──────────────────────────────────────────────
        foreach (range(7, 9) as $whId) {
            foreach ([1, 2, 3, 4, 5] as $sensorId) {
                $avg    = round(24 + (rand(-20, 20) / 10), 2);   // ~22–26 s
                $data[] = [
                    'line_id'      => 2,
                    'work_hour_id' => $whId,
                    'pattern_id'   => 3,
                    'sensor_id'    => $sensorId,
                    'average'      => $avg,
                    'maximal'      => round($avg + rand(3, 8), 2),
                    'minimal'      => round($avg - rand(3, 8), 2),
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }

        DB::table('sensor_summaries')->insert($data);
    }
}
