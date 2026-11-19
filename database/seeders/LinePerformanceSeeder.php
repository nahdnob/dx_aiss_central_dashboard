<?php

namespace Database\Seeders;

use App\Models\LinePerformance;
use Illuminate\Database\Seeder;;

class LinePerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas=[
            [
                'month'   => 'August',
                'year'    => '2025',
                'target'  => 88.0,
                'actual'  => 84.6,
                'line_id' => 2
            ],
            [
                'month'   => 'September',
                'year'    => '2025',
                'target'  => 88.0,
                'actual'  => 84.8,
                'line_id' => 2
            ],
            [
                'month'   => 'October',
                'year'    => '2025',
                'target'  => 88.0,
                'actual'  => 86.9,
                'line_id' => 2
            ],
            [
                'month'   => 'November',
                'year'    => '2025',
                'target'  => 88.0,
                'actual'  => 88.2,
                'line_id' => 2
            ],
            [
                'month'   => 'December',
                'year'    => '2025',
                'target'  => 88.0,
                'actual'  => 84.6,
                'line_id' => 2
            ]
        ];

        foreach ($datas as $data) {
            LinePerformance::create($data);
        }
    }
}
