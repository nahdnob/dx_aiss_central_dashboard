<?php

namespace App\Services\Dashboard;

use App\Models\Pattern;
use Illuminate\Database\Eloquent\Collection;

class PatternService
{
    public function get(int $lineId): Collection
    {
        return Pattern::where('line_id', $lineId)->get();
    }
}