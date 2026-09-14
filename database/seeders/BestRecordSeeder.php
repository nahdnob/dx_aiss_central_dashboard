<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ncd;

class BestRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ncd::create([
            'line_id'=> 2,
            'date'   => '2020-04-24',
            'claim'  => 'dummy',
            'action' => 'dummy'
        ]);
    }
}
