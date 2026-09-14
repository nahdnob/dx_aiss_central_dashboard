<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sensor;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Idempotent: safe on a fresh install (creates both lines' sensor catalogs)
     * or against the existing DB (pre-multi-line rows already got backfilled
     * onto Line 2 by the add_line_id_to_cycle_time_tables migration, so this
     * only fills in Line 1's mirror).
     *
     * Sensor 1 and 5 are the dual-strobe pair on this line's current topology
     * (see docs/PRD-multi-line-support.md §5.2) — mirrored identically for Line 1.
     */
    public function run(): void
    {
        // Line 2 first so its sensors keep IDs 1-7, matching what the already
        // deployed Node-RED flow sends today (raw D-memory position, 1-based).
        foreach ([2, 1] as $lineId) {

            if (Sensor::where('line_id', $lineId)->exists()) {
                continue;
            }

            for ($i = 1; $i <= 7; $i++) {
                Sensor::create([
                    'name'    => "Sensor {$i}",
                    'line_id' => $lineId,
                ]);
            }
        }
    }
}
