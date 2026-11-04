<?php

namespace App\Services\Production;

use App\Models\ProductIn;
use App\Models\ProductOut;
use App\Models\ProductSummary;

class SummaryService
{
    public function updateSummary(ProductIn $in): void
    {
        $latest = ProductSummary::where('line_id', $in->line_id)
            ->orderByDesc('id')
            ->first();

        if ($latest && $in->id < $latest->first_id) {
            // ProductIn lama (run sebelumnya), misal baru di-proses:
            // cari summary yang mencakup id ini, hanya hitung ulang qty
            $summary = ProductSummary::where('line_id', $in->line_id)
                ->where('first_id', '<=', $in->id)
                ->where('last_id', '>=', $in->id)
                ->first();

            if ($summary) {
                $this->recalculateQty($summary);
            }
            return;
        }

        if ($latest && $latest->part_number === $in->part_number) {
            // part number masih sama -> update
            $latest->last_id = max($latest->last_id, $in->id);
            $summary = $latest;
        } else {
            // part number berbeda (atau belum ada summary) -> create baru
            $summary = new ProductSummary([
                'line_id'     => $in->line_id,
                'part_number' => $in->part_number,
                'first_id'    => $in->id,
                'last_id'     => $in->id,
            ]);
        }

        $this->recalculateQty($summary);
    }

    private function recalculateQty(ProductSummary $summary): void
    {
        $sum = ProductIn::where('line_id', $summary->line_id)
            ->whereBetween('id', [$summary->first_id, $summary->last_id])
            ->selectRaw('
                SUM(quantity) as qty_in,
                SUM(CASE WHEN is_processed = 1 THEN quantity ELSE 0 END) as qty_out
            ')
            ->first();

        $summary->qty_in  = $sum->qty_in ?? 0;
        $summary->qty_out = $sum->qty_out ?? 0;
        $summary->save();
    }
}