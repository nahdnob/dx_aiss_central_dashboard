<?php

namespace App\Services\Dashboard;

use App\Models\PatternHistory;

class PatternHistoryService
{
    public function get(int $lineId): PatternHistory|null
    {
        return PatternHistory::where('line_id', $lineId)->latest()->first();
    }
}