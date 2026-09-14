<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pattern;
use App\Models\SensorHistory;
use App\Models\SensorSummary;
use App\Models\Sensor;
use App\Models\Shift;

use App\Services\CycleTime\CycleTimeQueryService;
use App\Services\CycleTime\RealtimeService;
use App\Services\CycleTime\FilterService;
use App\Services\CycleTime\SummaryService;
use App\Services\CycleTime\ExportService;

class CycleTimeController extends Controller
{
    public function __construct(
        private CycleTimeQueryService $queryService,
        private RealtimeService $realtimeService,
        private FilterService $filterService,
        private SummaryService $summaryService,
        private ExportService $exportService,
    ) {}

    public function index()
    {
        $active          = $this->queryService->getActivePattern();
        $activePatternId = $active['id'];
        $activePattern   = $active['data'];

        $lineId = session('selected_line_id');

        $patterns = $this->queryService->getAllPatterns();
        $sensors  = Sensor::where('line_id', $lineId)->orderBy('id', 'asc')->get();

        $realtimeSummary = $this->realtimeService->getTodaySummary($activePatternId, $lineId);
        $realtimeData    = $this->realtimeService->calculateRealtime($activePattern, $realtimeSummary);

        $recentLogs = SensorHistory::with('sensor:id,name', 'pattern:id,name,cycle_time')
            ->where('line_id', $lineId)
            ->when($activePatternId, fn($q) => $q->where('pattern_id', $activePatternId))
            ->latest('time')
            ->paginate(5);

        $filterPatternId = request('pattern_id') ?: $activePatternId;
        $filterPattern   = $filterPatternId ? Pattern::where('line_id', $lineId)->find($filterPatternId) : null;

        $scatterQuery = SensorHistory::with('sensor:id,name')
            ->where('line_id', $lineId)
            ->when($filterPatternId, fn($q) => $q->where('pattern_id', $filterPatternId));

        $hourlySummaryQuery = SensorSummary::with('sensor:id,name', 'workHour:id,hour_number,time_start,time_end')
            ->where('line_id', $lineId)
            ->when($filterPatternId, fn($q) => $q->where('pattern_id', $filterPatternId))
            ->orderBy('work_hour_id')
            ->orderBy('sensor_id');

        [$filterDate, $filterShiftId, $shifts] = $this->filterService->resolve(
            $filterPatternId,
            request('date'),
            request('shift_id')
        );

        $scatterQuery = $this->filterService->apply($scatterQuery, $filterDate, $filterShiftId);

        $hourlySummaryQuery = $this->filterService->apply(
            $hourlySummaryQuery,
            $filterDate,
            $filterShiftId,
            'created_at'
        )->whereHas('workHour', fn($q) => $q->where('shift_id', $filterShiftId));

        $scatterData = $this->summaryService->getScatterData($scatterQuery);
        $summaryData = $this->summaryService->getSummaryData($hourlySummaryQuery, $sensors);

        return view('cycletimes.monitoring.index', compact(
            'activePattern',
            'patterns',
            'sensors',
            'realtimeData',
            'recentLogs',
            'scatterData',
            'summaryData',
            'shifts',
            'filterDate',
            'filterShiftId',
            'filterPatternId',
            'filterPattern',
        ));
    }

    public function exportCsv(Request $request)
    {
        $patternId = $request->pattern_id;
        $date      = $request->date;
        $shiftId   = $request->shift_id;

        $logs = $this->exportService->getFilteredLogs($patternId, $date, $shiftId, session('selected_line_id'));
        $pos  = $this->exportService->getPosMapping();

        return $this->exportService->streamCsv($logs, $pos, $date);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->exportService->getPdfData(
            $request->pattern_id,
            $request->date,
            $request->shift_id,
            session('selected_line_id')
        );

        return view('cycletimes.monitoring.pdf', [
            'logs'        => $data['logs'],
            'filterDate'  => $data['date'],
            'shift'       => $data['shift'],
            'pattern'     => $data['pattern'],
            'posMapping'  => $data['posMapping'],
        ]);
    }
}
