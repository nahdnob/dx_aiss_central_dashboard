<?php

namespace Database\Seeders;

use App\Models\Dasg;
use Illuminate\Database\Seeder;

class DasgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'            => 'DAS080200g',
                'detail_standard' => 'Standard for work risk assessment',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das080200g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110100g',
                'detail_standard' => 'Safety standard of hazardous and harmful materials',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110100g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110300g',
                'detail_standard' => 'Safety standard of dust',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110300g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120120g',
                'detail_standard' => 'Common safety standard to equipment',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120120g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120121g',
                'detail_standard' => 'Safety standard of one cycle start system',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120121g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121253g',
                'detail_standard' => 'Safety standard of hand platform truck',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121253g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS071001g',
                'detail_standard' => 'Standard of implementing periodic maintenance',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das071001g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS600010g',
                'detail_standard' => 'Common standards for production environment',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das600010g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS700010g',
                'detail_standard' => 'Safety standard of joint work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das700010g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS080100g',
                'detail_standard' => 'Standard for equipment risk assessment',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das080100g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS091000g',
                'detail_standard' => "Standard for safety, health and environment control of contractor's construction",
                'revision'        => 1,
                'link'            => 'dasgs/mock_das091000g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS700011g',
                'detail_standard' => 'Safety standard of complex work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das700011g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121254g',
                'detail_standard' => 'Safety standard of transfer machines : hand pallet truck',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121254g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS700016g',
                'detail_standard' => 'Standard of handling belt and chain',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das700016g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS733001g',
                'detail_standard' => 'Standard of handling heavy object',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das733001g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110613g',
                'detail_standard' => 'Safety standard of using rubber hose for gas',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110613g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110652g',
                'detail_standard' => 'Standard of installing gas alarm system',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110652g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120130g',
                'detail_standard' => 'Safety standard of light curtain',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120130g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120970g',
                'detail_standard' => 'Safety standard of dust collector : general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120970g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121257g',
                'detail_standard' => 'Safety standard of traveling path for in-plant transportation vehicles',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121257g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121261g',
                'detail_standard' => 'Safety standard of crane',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121261g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS700092g',
                'detail_standard' => 'Safety standard of dust collecting work : general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das700092g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS700093g',
                'detail_standard' => 'Safety standard for work at height',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das700093g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS720005g',
                'detail_standard' => 'Standard of maintenance work : general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das720005g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS733002g',
                'detail_standard' => 'Safety standard of carrying work : sling and crane operation',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das733002g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS790210g',
                'detail_standard' => 'Other work : Standard of forklift operation',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das790210g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110110g',
                'detail_standard' => 'Criteria of combustible gas and vapor dangerous place',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110110g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110150g',
                'detail_standard' => 'Standard of duct fire prevention measures',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110150g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110170g',
                'detail_standard' => 'Standard of preventing duct fire of heating furnace',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110170g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110611g',
                'detail_standard' => 'Standard of main valve control for combustible gas',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110611g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS110651g',
                'detail_standard' => 'Standard of installing gas piping',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das110651g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120150g',
                'detail_standard' => 'Safety standard of air pressure release circuit',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120150g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120200g',
                'detail_standard' => 'Safety standard of press machine : general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120200g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120300g',
                'detail_standard' => 'Safety standard of molding machines',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120300g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120430g',
                'detail_standard' => 'Safety standard of die casting : die casting machine (casting machine)',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120430g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120432g',
                'detail_standard' => 'Safety standard of die casting: melting furnace and holding furnace',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120432g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120434g',
                'detail_standard' => 'Safety standard for die casting machine installing plant',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120434g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120501g',
                'detail_standard' => 'Safety standard of cutting machines : general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120501g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120528g',
                'detail_standard' => 'Safety standard of equipment that uses cartridge filters',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120528g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120810g',
                'detail_standard' => 'Safety standard of industrial robot',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120810g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120820g',
                'detail_standard' => 'Safety standard of laser device',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120820g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120930g',
                'detail_standard' => 'Safety standard of treatment device : standard of coating equipment',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120930g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120932g',
                'detail_standard' => 'Safety standard of electrostatic powder spray coating device',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120932g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120950g',
                'detail_standard' => 'Safety standard of equipment that uses high-pressure oil',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120950g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120951g',
                'detail_standard' => 'Safety standard of gas carburizing and quenching furnace',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120951g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120971g',
                'detail_standard' => 'Safety standard of zinc shot blast machine for aluminum die casting',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120971g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS120975g',
                'detail_standard' => 'Safety standard of dust collector: general-purpose high pressure bag filters',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das120975g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121010g',
                'detail_standard' => 'Safety standard of electric device : anti-static measures',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121010g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121211g',
                'detail_standard' => 'Standard of safety guarding workpiece transportation part',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121211g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121215g',
                'detail_standard' => 'Standard of material stock area',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121215g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121249g',
                'detail_standard' => 'Standard of forklift operation area: forklift elimination and measures to separate',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121249g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121250g',
                'detail_standard' => 'Safety standard of forklifts',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121250g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121252g',
                'detail_standard' => 'Safety standard of walkie forklift',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121252g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS121271g',
                'detail_standard' => 'Safety standard of AIV (automated industrial vehicles)',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das121271g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS601010g',
                'detail_standard' => 'Procedure for environmental site assessment prior to acquisition of property etc.',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das601010g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS602010g',
                'detail_standard' => 'Control standard for prohibition of use of chemical substances, etc.',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das602010g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS710100g',
                'detail_standard' => 'Safety standard of press work : general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das710100g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS711000g',
                'detail_standard' => 'Safety standard of resin molding work : general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das711000g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS712110g',
                'detail_standard' => 'Safety standard of die casting operation : replacing ladle work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das712110g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS712111g',
                'detail_standard' => 'Standard of die casting operation: coating, drying, pre-heating work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das712111g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS713510g',
                'detail_standard' => 'Safety standard of handling industrial robot',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das713510g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS714001g',
                'detail_standard' => 'Safety standard of machine processing work : general rule of cutting work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das714001g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS715000g',
                'detail_standard' => 'Safety standard of treatment work : general rule of heat treatment work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das715000g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS715004g',
                'detail_standard' => 'Safety standard of treatment work : gas carburizing and quenching furnace work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das715004g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS715030g',
                'detail_standard' => 'Safety standard of treatment work : coating work general rule',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das715030g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS715054g',
                'detail_standard' => 'Standard of electrostatic powder spray coating work',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das715054g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS715170g',
                'detail_standard' => 'Standard of handling laser device',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das715170g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS750201g',
                'detail_standard' => 'Safety standard of hazardous materials : standard of checking gas leak',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das750201g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS790010g',
                'detail_standard' => 'Safety standard of work at testing room',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das790010g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS790206g',
                'detail_standard' => 'Standard of transportation equipment : electric pallet truck operation',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das790206g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS790207g',
                'detail_standard' => 'Standard of transportation equipment: hand pallet truck operation',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das790207g.pdf',
                'line_id'         => 2
            ],
            [
                'name'            => 'DAS790215g',
                'detail_standard' => 'Other work : Standard of walkie forklift operation',
                'revision'        => 1,
                'link'            => 'dasgs/mock_das790215g.pdf',
                'line_id'         => 2
            ],
        ];

        foreach ($datas as $data) {
            Dasg::create($data);
        }
    }
}
