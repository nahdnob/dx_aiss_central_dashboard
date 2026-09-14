<?php

namespace Database\Seeders;

use App\Models\RiskAssessment;
use Database\Seeders\Data\SopRiskAssessmentData;
use Illuminate\Database\Seeder;

class RiskAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Replace whatever is currently in the table with the AISS Line 2 RA register.
        RiskAssessment::query()->delete();

        foreach (SopRiskAssessmentData::rows() as $row) {
            RiskAssessment::create([
                'name'             => $row['name'],
                'ra_no'            => $row['ra_no'],
                'ra_level'         => 1,
                'ra_security_rank' => 'C',
                'revision'         => 1,
                'link'             => 'risk_assessments/' . strtolower($row['ra_no']) . '.pdf',
                'line_id'          => 2,
            ]);
        }
    }
}
