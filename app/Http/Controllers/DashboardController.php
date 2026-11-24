<?php

namespace App\Http\Controllers;

use App\Models\SensorHistory;
use App\Models\Sop;
use App\Services\CycleTime\CycleTimeQueryService;
use App\Services\CycleTime\FilterService;
use App\Services\CycleTime\RealtimeService;
use App\Services\CycleTime\SummaryService;
use App\Services\Dashboard\BestRecordService;
use App\Services\Dashboard\LinePerformanceService;
use App\Services\Dashboard\MarqueeTextService;
use App\Services\Dashboard\ProductService;
use App\Services\Production\ProductStatsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private BestRecordService $bestRecordService,
        private LinePerformanceService $linePerformanceService,
        private MarqueeTextService $marqueeTextService,
        private CycleTimeQueryService $cycleTimeQueryService,
        private RealtimeService $realtimeService,
        private FilterService $filterService,
        private SummaryService $summaryService,
        private ProductStatsService $productStatsService,
        private ProductService $productService,
    ) {}

    /**
     * Halaman utama (Home) setelah login untuk semua role.
     */
    public function index(): View
    {
        $lineId = session('selected_line_id');

        // 1. Best Record & 3. Line Performance (berlaku untuk semua line)
        $bestRecord       = $this->bestRecordService->get();
        $linePerformances = $this->linePerformanceService->get()['linePerformances'];

        // Data di bawah ini spesifik per line → hanya dimuat jika line sudah dipilih
        $lineData = $lineId ? [
            // 2. Degree of Security Rank
            'matrix'        => $this->securityMatrix($lineId),

            // 4. Real-time Performance Chart + Mode
            ...$this->cycleTimeData($lineId),

            // 5. Production cards + Work in Progress
            ...$this->productStatsService->get($lineId),
            'products'      => $this->productService->get(),
        ] : [];

        return view('dashboards.index', [
            'selectedLineId'   => $lineId,
            'best_record'      => $bestRecord,
            'linePerformances' => $linePerformances,
            'marqueeText'      => $this->marqueeTextService->get(),
            ...$lineData,
        ]);
    }

    public function fetchProductsTable()
    {
        $products = $this->productService->get();

        return view('dashboards.partials.product-table', compact('products'));
    }

    private function cycleTimeData(int $lineId): array
    {
        $active        = $this->cycleTimeQueryService->getActivePattern();
        $activePattern = $active['data'];

        $summary      = $this->realtimeService->getTodaySummary($active['id'], $lineId);
        $realtimeData = $this->realtimeService->calculateRealtime($activePattern, $summary);

        $historyQuery = fn () => SensorHistory::where('line_id', $lineId)
            ->when($active['id'], fn ($q) => $q->where('pattern_id', $active['id']));

        // Trend: shift terakhir yang punya data untuk mode aktif (sama seperti default Cycle Time Monitoring)
        [$date, $shiftId] = $this->filterService->resolve($active['id'], null, null);
        $trendData = $this->summaryService->getScatterData(
            $this->filterService->apply($historyQuery()->with('sensor:id,name'), $date, $shiftId),
            $activePattern
        );

        return [
            'activePattern'  => $activePattern,
            'patterns'       => $this->cycleTimeQueryService->getAllPatterns(),
            'realtimeData'   => $realtimeData,
            'recentActivity' => $this->realtimeService->getRecentActivity($activePattern, $lineId, 5),
            'trendData'      => $trendData,
        ];
    }

    private function securityMatrix(int $lineId): array
    {
        $countSops = fn (string $rank, int $level) => Sop::where('line_id', $lineId)
            ->whereHas('riskAssessment', fn ($q) => $q->where('ra_security_rank', $rank)->where('ra_level', $level))
            ->count();

        $matrix = [];

        foreach (['A', 'C'] as $rank) {
            foreach ([1, 2, 3, 4] as $level) {
                $matrix[$rank][$level] = $countSops($rank, $level);
            }
        }

        $matrix['E']['no_ra'] = Sop::where('line_id', $lineId)->whereDoesntHave('riskAssessment')->count();

        return $matrix;
    }
}
