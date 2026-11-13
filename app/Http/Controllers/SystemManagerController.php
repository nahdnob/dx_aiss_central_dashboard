<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\RiskAssessment;
use App\Models\Sop;

use App\Models\Line;
use App\Services\Dashboard\LinePerformanceService;
use App\Services\Dashboard\BestRecordService;
use App\Services\Dashboard\CycleTimeService;
use App\Services\Dashboard\MarqueeTextService;
use App\Services\Dashboard\PatternService;
use App\Services\Dashboard\PatternHistoryService;
use App\Services\Dashboard\ProductService;

use Illuminate\Http\Request;

class SystemManagerController extends Controller
{
    public function __construct(
        private LinePerformanceService $linePerformanceService,
        private BestRecordService $bestRecordService,
        private CycleTimeService $cycleTimeService,
        private MarqueeTextService $marqueeTextService,
        private PatternService $patternService,
        private PatternHistoryService $patternHistoryService,
        private ProductService $productService,
    ) {}

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

        $dashboardLineId = 2;

        // 1. Best Record
        $bestRecord = $this->bestRecordService->get();

        // 2. Line Performance
        $linePerformanceData = $this->linePerformanceService->get();

        // 3. Cycle Time
        $cycleTimeData = $this->cycleTimeService->get($dashboardLineId);

        // 3. Products Table
        $products = $this->productService->get();

        // 4. Marquee Text
        $marqueeText = $this->marqueeTextService->get();

        // 5. Pattern
        $patterns = $this->patternService->get($dashboardLineId);

        $patternId = $this->patternHistoryService->get($dashboardLineId)?->pattern_id;
        $selectedLineId = session('selected_line_id');

        $lines = $selectedLineId ? collect() : Line::orderBy('name')->get();

        return view('system-managers.index', [
            'title'            => 'LINE 2', // Sesuaikan judulnya
            'dashboardLineId'  => $dashboardLineId,
            'products'         => $products,
            'best_record'      => $bestRecord,
            'cycleTimeData'    => $cycleTimeData,
            'linePerformances' => $linePerformanceData['linePerformances'],
            'labels'           => $linePerformanceData['labels'],
            'actual'           => $linePerformanceData['actual'],
            'minusOee'         => $linePerformanceData['minusOee'],
            'allowedTime'      => $linePerformanceData['allowedTime'],
            'marqueeText'      => $marqueeText,
            'patterns'         => $patterns,
            'patternId'        => $patternId,
            'lines'            => $lines,
            'selectedLineId'   => $selectedLineId,
            'machineCount'     => $machineCount,
            'totalSops'        => $totalSops,
            'sopsWithRa'       => $sopsWithRa,
            'matrix'           => $matrix,
        ]);
    }
}
