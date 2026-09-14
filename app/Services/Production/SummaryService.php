<?php

namespace App\Services\Production;

use App\Models\ProductIn;
use App\Models\ProductSummary;

class SummaryService
{
    public function updateSummary(int $lineId, string $partNumber): void
    {
        $data = ProductIn::where('part_number', $partNumber)
            ->where('line_id', $lineId)
            ->selectRaw('
                MIN(id) as first_id,
                MAX(id) as last_id,
                SUM(CASE WHEN is_processed = 0 THEN quantity ELSE 0 END) as qty_in,
                SUM(CASE WHEN is_processed = 1 THEN quantity ELSE 0 END) as qty_out
            ')
            ->first();

        if (!$data || !$data->first_id) {
            return;
        }

        ProductSummary::updateOrCreate(
            ['line_id' => $lineId,'part_number' => $partNumber],
            [
                'first_id' => $data->first_id,
                'last_id'  => $data->last_id,
                'qty_in'   => $data->qty_in ?? 0,
                'qty_out'  => $data->qty_out ?? 0,
            ]
        );
    }
}