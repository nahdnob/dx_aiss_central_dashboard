<?php

namespace App\Services\Production;

use App\Models\ProductIn;
use App\Models\ProductOut;

class ProductStatsService
{
    public const WIP_CAPACITY   = 680;
    public const WIP_MIN_NORMAL = 600;

    public function get(?int $lineId): array
    {
        $subAssyPartNumber = ProductIn::where('line_id', $lineId)
            ->latest('time_in')
            ->latest('id')
            ->value('part_number');

        $finalAssyPartNumber = ProductOut::where('line_id', $lineId)
            ->latest('time_out')
            ->latest('id')
            ->value('part_number');

        // WIP dalam satuan pcs: 1 row product_in biasanya berisi 2 pcs
        $wip = (int) ProductIn::where('line_id', $lineId)
            ->whereNull('product_out_id')
            ->where('is_processed', 0)
            ->sum('quantity');

        return [
            'subAssyPartNumber'   => $subAssyPartNumber,
            'finalAssyPartNumber' => $finalAssyPartNumber,
            'wip'                 => $wip,
            'wipCapacity'         => self::WIP_CAPACITY,
            'wipAbnormal'         => $wip < self::WIP_MIN_NORMAL,
        ];
    }
}
