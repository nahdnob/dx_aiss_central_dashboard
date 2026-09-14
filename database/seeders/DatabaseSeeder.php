<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // ── Core / Infrastructure ──────────────────────────────────
            OrganizationalStructureSeeder::class,
            ShiftSeeder::class,
            WorkHourSeeder::class,

            // ── Sensor & Pattern ──────────────────────────────────────
            SensorSeeder::class,
            PatternSeeder::class,
            PatternSensorSeeder::class,
            PatternHistorySeeder::class,

            // ── Sensor Summaries & Histories ──────────────────────────
            // (depends on: work_hours, sensors, patterns)
            SensorSummarySeeder::class,
            // (depends on: sensor_summaries, patterns, sensors)
            SensorHistorySeeder::class,

            // ── Products ──────────────────────────────────────────────
            // Creates product_ins + product_summaries
            // ProductSummarySeeder::class,
            // ProductInSeeder::class,   // legacy / manual parse seeder
            // ProductOutSeeder::class,  // legacy / manual parse seeder

            // ── Misc ──────────────────────────────────────────────────
            BestRecordSeeder::class,
            LinePerformanceSeeder::class,
            MarqueeTextSeeder::class,
            UserSeeder::class,
            RiskAssessmentSeeder::class,
            DasgSeeder::class,
            SopSeeder::class,
            MachineSeeder::class,
        ]);
    }
}
