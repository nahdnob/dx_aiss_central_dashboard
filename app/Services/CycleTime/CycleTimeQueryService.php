<?php

namespace App\Services\CycleTime;

use App\Models\Pattern;
use App\Models\PatternHistory;

class CycleTimeQueryService
{
    public function getActivePattern()
    {
        $lineId    = session('selected_line_id');
        $patternId = PatternHistory::where('line_id', $lineId)
            ->latest()
            ->value('pattern_id');

        return [
            'id'   => $patternId,
            'data' => $patternId
                ? Pattern::with('sensors')->find($patternId)
                : null
        ];
    }

    public function getAllPatterns()
    {
        return Pattern::where('line_id', session('selected_line_id'))->orderBy('name')->get();
    }
}