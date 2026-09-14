<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pattern;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Idempotent — see SensorSeeder for why (fresh install vs. backfilled DB).
     */
    public function run(): void
    {
        $patterns = [
            ['name' => '3MP', 'cycle_time' => 39.5, 'max_time' => 49.5, 'min_time' => 29.5],
            ['name' => '4MP', 'cycle_time' => 27.5, 'max_time' => 37.5, 'min_time' => 17.5],
            ['name' => '5MP', 'cycle_time' => 25, 'max_time' => 35, 'min_time' => 25],
            ['name' => '6MP', 'cycle_time' => 20, 'max_time' => 30, 'min_time' => 10],
            ['name' => '7MP', 'cycle_time' => 19, 'max_time' => 29, 'min_time' => 9],
        ];

        // Line 2 first so its patterns keep IDs 1-5 (unchanged from before multi-line support).
        foreach ([2, 1] as $lineId) {

            if (Pattern::where('line_id', $lineId)->exists()) {
                continue;
            }

            foreach ($patterns as $pattern) {
                Pattern::create($pattern + ['line_id' => $lineId]);
            }
        }
    }
}
