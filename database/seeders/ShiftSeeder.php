<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shift::create([
            'name'       => 'Shift Pagi',
            'time_start' => '07:30:00',
            'time_end'   => '20:00:00',
            'line_id'    => 2,
        ]);
        Shift::create([
            'name'       => 'Shift Malam',
            'time_start' => '20:00:00',
            'time_end'   => '07:30:00',
            'line_id'    => 2,
        ]);
    }
}
