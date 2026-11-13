<?php

namespace App\Services\Production;

use App\Models\ProductIn;
use App\Models\ProductOut;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FifoService
{
    public function process(ProductOut $productOut): Collection
    {
        return DB::transaction(function () use ($productOut) {

            $needed   = $productOut->quantity;
            $used     = 0;
            $usedRows = collect();

            $productIns = ProductIn::where('part_number', $productOut->part_number)
                ->whereNull('product_out_id')
                ->where('line_id', $productOut->line_id)
                ->where('is_processed', 0)
                ->where('time_in', '<=', $productOut->time_out)
                ->orderBy('time_in')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            foreach ($productIns as $pi) {
                if ($used >= $needed) {
                    break;
                }
                $used += $pi->quantity;
                $usedRows->push($pi);
            }

            if ($used < $needed) {
                Log::warning('FIFO gagal: stok tidak cukup', [
                    'product_out_id' => $productOut->id,
                    'part_number'    => $productOut->part_number,
                    'needed'         => $needed,
                    'available'      => $used,
                ]);

                return collect(); // kosong, bukan false
            }

            foreach ($usedRows as $pi) {
                $pi->update([
                    'product_out_id' => $productOut->id,
                    'is_processed'   => 1,
                ]);
            }

            return $usedRows;
        });
    }
}