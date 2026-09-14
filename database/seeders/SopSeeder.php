<?php

namespace Database\Seeders;

use App\Models\Sop;
use Database\Seeders\Data\SopRiskAssessmentData;
use Illuminate\Database\Seeder;

class SopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Replace whatever is currently in the table with the AISS Line 2 SOP register.
        Sop::query()->delete();

        // The source document reuses the same SOP number across several RA entries
        // (one physical SOP sheet can cover multiple risk items), but sops.sop_no is
        // unique in the schema, so repeats get a " (2)", " (3)", ... suffix here.
        $seenSopNo = [];

        foreach (SopRiskAssessmentData::rows() as $row) {
            $sopNo = $row['sop_no'];
            $seenSopNo[$sopNo] = ($seenSopNo[$sopNo] ?? 0) + 1;

            if ($seenSopNo[$sopNo] > 1) {
                $sopNo .= " ({$seenSopNo[$sopNo]})";
            }

            Sop::create([
                'name'     => $row['name'],
                'sop_no'   => $sopNo,
                'revision' => 1,
                'link'     => 'sops/' . strtolower($row['ra_no']) . '.pdf',
                'line_id'  => 2,
            ]);
        }
    }
}
