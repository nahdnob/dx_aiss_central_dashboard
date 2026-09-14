<?php

namespace Database\Seeders;

use App\Models\Pattern;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PatternHistory;

use Carbon\Carbon;

class PatternHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pattern 1 belongs to Line 2 (seeded first in PatternSeeder)
        PatternHistory::create([
            'pattern_id' => 1,
            'line_id'    => 2,
        ]);
    }
}
