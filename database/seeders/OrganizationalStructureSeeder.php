<?php

namespace Database\Seeders;

use App\Models\BusinessUnit;
use App\Models\Line;
use App\Models\Plant;
use App\Models\Section;
use Illuminate\Database\Seeder;

class OrganizationalStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Plant
        $plant = Plant::create(['name' => 'Plant AISS']);

        // Sections
        $section1 = Section::create(['plant_id' => $plant->id, 'section_no' => 'SEC-001', 'name' => 'Pressing Section']);
        $section2 = Section::create(['plant_id' => $plant->id, 'section_no' => 'SEC-002', 'name' => 'Welding Section']);
        $section3 = Section::create(['plant_id' => $plant->id, 'section_no' => 'SEC-003', 'name' => 'Assembly Section']);

        // Business Units
        $bu1 = BusinessUnit::create(['section_id' => $section1->id, 'bu_no' => 'BU-001', 'name' => 'Main Pressing']);
        $bu2 = BusinessUnit::create(['section_id' => $section1->id, 'bu_no' => 'BU-002', 'name' => 'Sub Pressing']);
        $bu3 = BusinessUnit::create(['section_id' => $section2->id, 'bu_no' => 'BU-003', 'name' => 'Robotic Welding']);
        $bu4 = BusinessUnit::create(['section_id' => $section2->id, 'bu_no' => 'BU-004', 'name' => 'Manual Welding']);
        $bu5 = BusinessUnit::create(['section_id' => $section3->id, 'bu_no' => 'BU-005', 'name' => 'Final Assembly']);

        // Lines
        Line::create(['bu_id' => $bu1->id, 'name' => 'Line 1']);
        Line::create(['bu_id' => $bu1->id, 'name' => 'Line 2', 'pokayoke_path' => '\\\\FU551324001\\Users\\ADMIN\\Documents\\Pokayoke\\DATA', 'kanban_path' => '\\\\192.168.2.1\\Users\\User\\Documents\\IGS']);
    }
}
