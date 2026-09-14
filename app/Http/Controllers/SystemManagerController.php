<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\RiskAssessment;
use App\Models\Sop;

use Illuminate\Http\Request;

class SystemManagerController extends Controller
{
    public function index()
    {
        $lineId = session('selected_line_id');

        $machineCount = Machine::where('line_id', $lineId)->count();
        $totalSops    = Sop::where('line_id', $lineId)->count();
        $sopsWithRa   = Sop::where('line_id', $lineId)->whereHas('riskAssessment')->count();

        $matrix = [
            'A' => [
                1 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'A')->where('ra_level', 1))->count(),
                2 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'A')->where('ra_level', 2))->count(),
                3 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'A')->where('ra_level', 3))->count(),
                4 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'A')->where('ra_level', 4))->count(),
            ],
            'C' => [
                1 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'C')->where('ra_level', 1))->count(),
                2 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'C')->where('ra_level', 2))->count(),
                3 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'C')->where('ra_level', 3))->count(),
                4 => Sop::where('line_id', $lineId)->whereHas('riskAssessment', fn($q) => $q->where('ra_security_rank', 'C')->where('ra_level', 4))->count(),
            ],
            'E' => [
                'no_ra' => Sop::where('line_id', $lineId)->whereDoesntHave('riskAssessment')->count(),
            ],
        ];

        return view('system-managers.index', compact('machineCount', 'totalSops', 'sopsWithRa', 'matrix'));
    }
}
