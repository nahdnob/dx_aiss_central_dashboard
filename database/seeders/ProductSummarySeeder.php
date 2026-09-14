<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductIn;
use Carbon\Carbon;

class ProductSummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates product_ins records for 3 part numbers,
     * then builds a product_summaries row for each part number.
     *
     * Interval between each scan  : 25–45 s (randomised)
     * Quantity per scan            : 2 pcs
     * Records per part number      : 50 scans  → qty_in = 100 pcs
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Part numbers to seed
        $partNumbers = [
            'JK039100-2230',
            'JK039100-2410',
            'JK039100-2240',
        ];

        foreach ($partNumbers as $index => $partNumber) {

            // Start time offset per part so timestamps don't overlap
            $startTime = Carbon::today()
                ->setTime(7, 35, 0)
                ->addHours($index * 2);

            $firstId = null;
            $lastId  = null;
            $qtyIn   = 0;

            for ($i = 1; $i <= 50; $i++) {
                // Build a deterministic, unique part_id
                $sanitised = strtoupper(str_replace(['-', ' '], '', $partNumber));
                $partId    = $sanitised . sprintf('%06d', ($index * 1000) + $i);

                $productIn = ProductIn::create([
                    'line_id'        => 2,
                    'product_out_id' => null,
                    'part_id'        => $partId,
                    'part_number'    => $partNumber,
                    'time_in'        => $startTime->copy(),
                    'quantity'       => 2,
                    'is_processed'   => 0,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ]);

                if ($i === 1)  $firstId = $productIn->id;
                $lastId = $productIn->id;
                $qtyIn += $productIn->quantity;

                $startTime->addSeconds(rand(25, 45));
            }

            DB::table('product_summaries')->insert([
                'line_id'     => 2,
                'part_number' => $partNumber,
                'first_id'    => $firstId,
                'last_id'     => $lastId,
                'qty_in'      => $qtyIn,
                'qty_out'     => 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
