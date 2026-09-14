<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MarqueeText;

class MarqueeTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MarqueeText::create([
            'line_id' => 2,
            'text'    => 'Orang sabar pasti kesel. (H. Drs. Kasir Ibnu)',
        ]);
    }
}
