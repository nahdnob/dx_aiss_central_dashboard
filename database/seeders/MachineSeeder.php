<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machines = [
            [
                'asset_no' => 'ME-7427-19-001',
                'asset_name' => 'Data Writer MC',
                'acquisition_date' => '2019-04-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-002',
                'asset_name' => 'PCB Separator MC',
                'acquisition_date' => '2019-12-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-012',
                'asset_name' => 'PCB Air Blow MC',
                'acquisition_date' => '2019-04-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-013',
                'asset_name' => 'Connector & Condenser Assy MC',
                'acquisition_date' => '2019-12-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'JD-7427-16-005',
                'asset_name' => 'Case Assembling Jig',
                'acquisition_date' => '2016-09-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-007',
                'asset_name' => 'Gel Applying MC',
                'acquisition_date' => '2019-04-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-015',
                'asset_name' => 'Vibration Case Assembly',
                'acquisition_date' => '2019-12-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-003',
                'asset_name' => 'Selective Soldering',
                'acquisition_date' => '2019-04-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'JD-7427-16-010',
                'asset_name' => 'Name Plate Pasting Jig',
                'acquisition_date' => '2016-09-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-011',
                'asset_name' => 'Preheating MC',
                'acquisition_date' => '2019-12-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-006',
                'asset_name' => 'Potting MC',
                'acquisition_date' => '2019-12-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-008',
                'asset_name' => 'Hardening Oven',
                'acquisition_date' => '2019-12-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-19-005',
                'asset_name' => 'In Circuit Checker MC',
                'acquisition_date' => '2019-12-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
            [
                'asset_no' => 'ME-7427-16-018',
                'asset_name' => 'Hardening Oven #3',
                'acquisition_date' => '2016-09-01',
                'manufacturer' => NULL,
                'model' => NULL,
                'line_id' => 2,
            ],
        ];

        foreach ($machines as $data) {
            $machine = Machine::create($data);
            // Link to SOPs (Many-to-Many via machine_sop)
            // if ($machine->asset_no === 'Asset-1') {
            //     $machine->sops()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
            // } elseif ($machine->asset_no === 'Asset-2') {
            //     $machine->sops()->sync([2]);
            // } elseif ($machine->asset_no === 'Asset-3') {
            //     $machine->sops()->sync([3, 4]);
            // } elseif ($machine->asset_no === 'Asset-4') {
            //     $machine->sops()->sync([4]);
            // } elseif ($machine->asset_no === 'Asset-5') {
            //     $machine->sops()->sync([5]);
            // } elseif ($machine->asset_no === 'Asset-6') {
            //     $machine->sops()->sync([6]);
            // } elseif ($machine->asset_no === 'Asset-7') {
            //     $machine->sops()->sync([7]);
            // } elseif ($machine->asset_no === 'Asset-8') {
            //     $machine->sops()->sync([8]);
            // } elseif ($machine->asset_no === 'Asset-9') {
            //     $machine->sops()->sync([9]);
            // } else {
            //     $machine->sops()->sync([10]);
            // }
        }
    }
}
