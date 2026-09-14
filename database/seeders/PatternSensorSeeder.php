<?php

namespace Database\Seeders;

use App\Models\Line;
use App\Models\Pattern;
use App\Models\Sensor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatternSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Data-driven and per-line: pattern "NMP" attaches to that line's own
     * sensors 1..N (by creation order), for every line that has the topology.
     * Idempotent — skips a pattern that's already wired up.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $pointsByPatternName = [
            '3MP' => 3,
            '4MP' => 4,
            '5MP' => 5,
            '6MP' => 6,
            '7MP' => 7,
        ];

        foreach (Line::pluck('id') as $lineId) {

            $sensorIds = Sensor::where('line_id', $lineId)->orderBy('id')->pluck('id')->values();

            foreach (Pattern::where('line_id', $lineId)->get(['id', 'name']) as $pattern) {

                if (DB::table('pattern_sensor')->where('pattern_id', $pattern->id)->exists()) {
                    continue;
                }

                $points = $pointsByPatternName[$pattern->name] ?? 0;
                $rows   = [];

                for ($pos = 1; $pos <= $points; $pos++) {

                    if (!isset($sensorIds[$pos - 1])) {
                        break;
                    }

                    $rows[] = [
                        'pattern_id' => $pattern->id,
                        'sensor_id'  => $sensorIds[$pos - 1],
                        'pos'        => $pos,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ($rows) {
                    DB::table('pattern_sensor')->insert($rows);
                }
            }
        }
    }
}
