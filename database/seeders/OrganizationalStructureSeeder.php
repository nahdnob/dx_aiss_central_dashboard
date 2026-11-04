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
        $plant = Plant::create(['name' => 'Fajar Plant']);

        // Sections
        $section1 = Section::create(['plant_id' => $plant->id, 'section_no' => 'SEC-001', 'name' => 'Production']);

        // Business Units
        $bu1 = BusinessUnit::create(['section_id' => $section1->id, 'bu_no' => '7427', 'name' => 'ECU AISS']);

        // Lines
        Line::create(['bu_id' => $bu1->id, 'name' => 'Assy Line 1']);
        Line::create(['bu_id' => $bu1->id, 'name' => 'Assy Line 2', 'pokayoke_path' => '\\\\FU551324001\\Users\\ADMIN\\Documents\\Pokayoke\\DATA', 'kanban_path' => '\\\\192.168.2.1\\Users\\User\\Documents\\IGS']);
    }
}
