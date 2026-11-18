<?php

namespace Database\Seeders;

use App\Models\Pattern;
use Illuminate\Database\Seeder;

class PatternExceptTimeSeeder extends Seeder
{
    /**
     * Isi except_time untuk pattern yang sudah ada (berdasarkan nama pattern).
     *
     * Aman dijalankan berulang. Pattern yang except_time-nya sudah diubah user
     * (bukan 0) tidak ditimpa.
     */
    public function run(): void
    {
        foreach (PatternSeeder::EXCEPT_TIMES as $name => $exceptTime) {
            Pattern::where('name', $name)
                ->where('except_time', 0)
                ->update(['except_time' => $exceptTime]);
        }
    }
}
