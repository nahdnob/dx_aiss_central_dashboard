@extends('layouts.system-manager')

@push('head')
    <meta http-equiv="refresh" content="60">
@endpush

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Monitoring Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/stopwatch.jpg') }}" alt="Cycle Time Monitoring" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
            </div>
            {{-- Decorative Right Background --}}
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-red-50 to-transparent z-20"></div>
            {{-- Decorative Glow Circle --}}
            <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-red-500/10 blur-3xl z-30"></div>

            <div class="relative z-40 flex flex-col lg:flex-row lg:items-center justify-between gap-4 px-8 py-5 pl-[380px] min-h-[140px]">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">CYCLE TIME MONITORING</h1>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-lg">
                        Real-time sensor performance &amp; cycle efficiency for
                        <span class="font-semibold text-red-600">AISS production line</span>.
                    </p>
                </div>

                {{-- Select Mode + Quick Info --}}
                <div class="flex flex-wrap items-center gap-3">

                    {{-- Inline Pattern Selector --}}
                    <form action="{{ route('pattern-histories.store') }}" method="POST"
                          class="flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl shadow-sm">
                        @csrf
                        <input type="hidden" name="line_id" value="{{ session('selected_line_id') }}">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Mode</label>
                        <select name="pattern"
                                class="bg-white border border-gray-200 text-gray-800 text-xs font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent px-2.5 py-1.5 transition-all">
                            @foreach($patterns as $p)
                                <option value="{{ $p->id }}" {{ $activePattern?->id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="px-4 py-1.5 bg-gradient-to-r from-red-600 to-rose-700 hover:brightness-110 text-white text-xs font-bold rounded-lg transition-all duration-200 shadow-sm whitespace-nowrap uppercase">
                            Apply
                        </button>
                    </form>

                    {{-- Quick Info Badge --}}
                    @if($activePattern)
                    <div class="flex items-center gap-4 px-5 py-2.5 bg-gray-50 rounded-xl border border-gray-200 shadow-sm">
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active Mode</p>
                            <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $activePattern->name }}</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">SCL</p>
                            <p class="text-xs font-bold text-red-600 mt-0.5">{{ $activePattern->cycle_time }}s</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">LCL / UCL</p>
                            <p class="text-xs font-bold text-gray-700 mt-0.5">{{ $activePattern->min_time }}s / {{ $activePattern->max_time }}s</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ===== MAIN GRID ===== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">

            {{-- Chart Card (2/3 width) --}}
            <div class="xl:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden h-full flex flex-col">
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                        <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            Real-time Performance Chart
                        </h3>
                        <div class="flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-emerald-400 inline-block"></span> Normal</span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-red-400 inline-block"></span> Abnormal</span>
                            <span class="flex items-center gap-1.5"><span class="w-6 border-t-2 border-dashed border-red-500 inline-block"></span> SCL</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">

                    @if(count($realtimeData) > 0)
                        <div class="h-72 w-full">
                            <canvas id="realtimeChart"></canvas>
                        </div>
                    @else
                    <div class="h-72 flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                        <p class="text-sm italic">No realtime data available yet.</p>
                        <p class="text-xs mt-1">Waiting for active pattern data...</p>
                    </div>
                    @endif
                    </div>
                </div>
            </div>

            {{-- Logs Card (1/3 width) --}}
            <div class="xl:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden h-full flex flex-col">
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                        <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            Recent Activity Log
                        </h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2.5 py-1 rounded-full border border-gray-150">
                            {{ $recentLogs->total() }} entries
                        </span>
                    </div>

                    <div class="overflow-y-auto flex-1">
                        <table class="w-full text-left">
                            <thead class="sticky top-0">
                                <tr class="bg-gray-50/80">
                                    <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">Time</th>
                                    <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">Sensor</th>
                                    <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 text-center">Dur.</th>
                                    <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentLogs as $log)
                                    <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                                        <td class="px-5 py-3 whitespace-nowrap">
                                            <span class="text-xs font-medium text-gray-500">
                                                {{ \Carbon\Carbon::parse($log->time)->format('H:i:s') }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full {{ $log->status == 1 ? 'bg-emerald-400' : 'bg-red-400' }}"></div>
                                                <span class="text-xs font-semibold text-gray-700">{{ $log->sensor?->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            <span class="text-xs font-bold text-gray-900">{{ number_format($log->duration, 2) }}<span class="font-normal text-gray-400 ml-0.5">s</span></span>
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            @if($log->status == 1)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-wide">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> OK
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-wide">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> NG
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center text-gray-400">
                                                <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                <p class="text-sm italic">No activity recorded yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($recentLogs->hasPages())
                    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex items-center justify-between text-xs">
                        <div class="w-full relative">
                            {{ $recentLogs->withQueryString()->links('pagination::simple-tailwind') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ===== HISTORICAL REPORT & FILTER ===== --}}
        <div class="mb-6">
            <div class="flex items-end justify-between mb-3">
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Analysis Data</p>
                    <h2 class="text-xl font-bold text-gray-900">Shift Report & Scatter</h2>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">
                <form method="GET" action="{{ route('cycletimes.monitoring.index') }}" class="flex flex-wrap items-end justify-between gap-4">
                    <div class="flex flex-wrap items-end gap-4 flex-1">
                        {{-- Date Input --}}
                        <div class="min-w-[150px]">
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5 ml-1">Date</label>
                            <input type="date" name="date" value="{{ $filterDate }}" required
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Shift Select --}}
                        <div class="min-w-[200px]">
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5 ml-1">Shift</label>
                            <select name="shift_id" required
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                                <option value="">-- Select Shift --</option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->id }}" {{ $filterShiftId == $shift->id ? 'selected' : '' }}>
                                        {{ $shift->name }} ({{ \Carbon\Carbon::parse($shift->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->time_end)->format('H:i') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Mode Select --}}
                        <div class="min-w-[200px]">
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5 ml-1">Mode</label>
                            <select name="pattern_id" required
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                                <option value="">-- Select Mode --</option>
                                @foreach($patterns as $p)
                                    <option value="{{ $p->id }}" {{ $filterPatternId == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Search & Reset Buttons --}}
                        <div class="flex items-center gap-2">
                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">
                                Search
                            </button>
                            @if(request()->filled('date') || request()->filled('shift_id'))
                                <a href="{{ route('cycletimes.monitoring.index') }}" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition shrink-0 uppercase">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Export Buttons --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('cycletimes.monitoring.export-csv', ['date' => $filterDate, 'shift_id' => $filterShiftId, 'pattern_id' => $filterPatternId]) }}" 
                           class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:brightness-110 text-white text-sm font-bold rounded-xl shadow-sm transition uppercase"
                           title="Export to CSV">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            CSV
                        </a>
                        <a href="{{ route('cycletimes.monitoring.export-pdf', ['date' => $filterDate, 'shift_id' => $filterShiftId, 'pattern_id' => $filterPatternId]) }}" 
                           target="_blank"
                           class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:brightness-110 text-white text-sm font-bold rounded-xl shadow-sm transition uppercase"
                           title="Export to PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            PDF
                        </a>
                    </div>
                </form>
            </div>
        </div>
        {{-- ===== SCATTER DIAGRAM ===== --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                    Scatter Diagram — Cycle Time Over Time
                </h3>
                <div class="flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span> Normal</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400 inline-block"></span> Abnormal</span>
                    <span class="flex items-center gap-1.5"><span class="w-6 border-t-2 border-red-500 inline-block"></span> UCL</span>
                    <span class="flex items-center gap-1.5"><span class="w-6 border-t-2 border-amber-500 inline-block"></span> LCL</span>
                </div>
            </div>

            <div class="p-6">
                @if($scatterData->count() > 0)
                <div class="h-64 w-full">
                    <canvas id="scatterChart"></canvas>
                </div>
                @else
                <div class="h-64 flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="6" cy="6" r="1.5" fill="currentColor"/><circle cx="12" cy="10" r="1.5" fill="currentColor"/><circle cx="18" cy="4" r="1.5" fill="currentColor"/></svg>
                    <p class="text-sm italic">No data to plot for the selected period.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- ===== HOURLY SUMMARY ===== --}}
        <div class="mt-8 mb-6 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2 uppercase tracking-wide">
                <span class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Hourly Summarize
                <span class="text-red-600 font-extrabold ml-1">Cycle Time</span>
            </h2>
        </div>

        <div class="space-y-6">
            @forelse ($summaryData as $i => $summary)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                        <h4 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            POS {{ substr($summary['sensor_name'], -1) }} — {{ $summary['sensor_name'] }}
                        </h4>
                    </div>
                    <div class="p-6">

                    {{-- Summary Chart --}}
                    <div class="h-56 w-full mb-6">
                        <canvas id="chart_summary_{{ $i }}"></canvas>
                    </div>

                    {{-- Summary Table --}}
                    <div class="overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100 uppercase text-[10px] tracking-wider text-gray-400">
                                <tr>
                                    <th class="px-5 py-3 text-center font-bold w-24">Metric</th>
                                    @foreach ($summary['jam'] as $hour => $values)
                                        <th class="px-5 py-3 text-center font-bold whitespace-nowrap">Jam ke-{{ $hour }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs">
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-3 text-center font-bold text-gray-400 bg-gray-50/50">MAX</td>
                                    @foreach ($summary['jam'] as $values)
                                        <td class="px-5 py-3 text-center text-gray-600 font-semibold">{{ $values['max'] == 0 ? '-' : $values['max'] . 's' }}</td>
                                    @endforeach
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-3 text-center font-bold text-sky-500 bg-gray-50/50">AVG</td>
                                    @foreach ($summary['jam'] as $values)
                                        <td class="px-5 py-3 text-center text-sky-600 font-bold bg-sky-50/30">{{ $values['avg'] == 0 ? '-' : $values['avg'] . 's' }}</td>
                                    @endforeach
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-3 text-center font-bold text-gray-400 bg-gray-50/50">MIN</td>
                                    @foreach ($summary['jam'] as $values)
                                        <td class="px-5 py-3 text-center text-gray-600 font-semibold">{{ $values['min'] == 0 ? '-' : $values['min'] . 's' }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-medium">Belum ada data summary pada hari ini.</p>
                </div>
            @endforelse
        </div>

    </div>
    <x-ui.footer />
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3"></script>
<script>
    const CdnChart = window.Chart;

    document.addEventListener('DOMContentLoaded', function () {
        // ─── Chart ──────────────────────────────────────────────────────
        @if(count($realtimeData) > 0)
        const ctx      = document.getElementById('realtimeChart').getContext('2d');
        const labels   = @json(collect($realtimeData)->pluck('sensor_name'));
        const durations = @json(collect($realtimeData)->pluck('duration'));
        const activeScl = {{ $activePattern?->cycle_time ?? 0 }};
        const activeMaxTime = {{ $activePattern?->max_time ?? 0 }};

        new CdnChart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Cycle Time (s)',
                    data: durations,
                    backgroundColor: durations.map(v => v > activeScl
                        ? 'rgba(239,68,68,0.80)'
                        : 'rgba(34,197,94,0.80)'),
                    borderRadius: 8,
                    borderWidth: 0,
                    barThickness: 'flex',
                    maxBarThickness: 48,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: activeMaxTime > 0 ? activeMaxTime + 5 : undefined,
                        grid: { color: '#f3f4f6', drawBorder: false },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af',
                                callback: v => v + 's' },
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: '600' }, color: '#4b5563' }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont:  { size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y.toFixed(2)}s  ${ctx.parsed.y > activeScl ? '⚠ Abnormal' : '✓ Normal'}`
                        }
                    },
                    annotation: {
                        annotations: {
                            sclLine: {
                                type: 'line',
                                yMin: activeScl,
                                yMax: activeScl,
                                borderColor: 'rgba(239,68,68,0.90)',
                                borderWidth: 2,
                                borderDash: [6, 4],
                                label: {
                                    display: true,
                                    content: 'SCL ' + activeScl + 's',
                                    position: 'end',
                                    backgroundColor: 'rgba(239,68,68,0.85)',
                                    color: '#fff',
                                    font: { size: 10, weight: 'bold' },
                                    padding: { x: 8, y: 4 },
                                    borderRadius: 6,
                                }
                            }
                        }
                    }
                }
            }
        });
        @endif

        // ─── Scatter Chart ───────────────────────────────────────────────
        @if($scatterData->count() > 0)
        const scatterCtx = document.getElementById('scatterChart')?.getContext('2d');
        if (scatterCtx) {
            const scatterRaw   = @json($scatterData);
            const scatterScl   = {{ $filterPattern?->cycle_time ?? 0 }};
            const scatterMaxTime = {{ $filterPattern?->max_time ?? 0 }};
            const scatterMinTime = {{ $filterPattern?->min_time ?? 0 }};
            const scatterLabels = scatterRaw.map(d => d.x);
            const scatterPoints = scatterRaw.map((d, i) => ({ x: i, y: Number(d.y) }));
            const scatterColors = scatterRaw.map(d => d.status == 1
                ? 'rgba(34,197,94,0.65)'
                : 'rgba(239,68,68,0.75)');

            // ── Moving Average ──
            const MA_WINDOW = 30; // jumlah titik per rata-rata, ubah sesuai kebutuhan

            function movingAverage(values, windowSize) {
                return values.map((_, i) => {
                    const start = Math.max(0, i - windowSize + 1);
                    const slice = values.slice(start, i + 1);
                    return slice.reduce((a, b) => a + b, 0) / slice.length;
                });
            }

            const maValues = movingAverage(scatterPoints.map(p => p.y), MA_WINDOW);
            const maPoints = maValues.map((y, i) => ({ x: i, y }));

            new CdnChart(scatterCtx, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Cycle Time',
                        data: scatterPoints,
                        backgroundColor: scatterColors,
                        pointRadius: 2,
                        pointHoverRadius: 5,
                        order: 2,
                    },
                    {
                    type: 'line',
                    label: 'MA ' + MA_WINDOW,
                    data: maPoints,
                    borderColor: 'rgba(59,130,246,0.95)', // biru
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    tension: 0.3,
                    fill: false,
                    order: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'linear',
                            ticks: {
                                font: { size: 10 }, color: '#6b7280',
                                callback: v => scatterLabels[v] ?? v,
                                maxTicksLimit: 12,
                            },
                            grid: { color: '#f3f4f6' }
                        },
                        y: {
                            beginAtZero: true,
                            max: scatterMaxTime > 0 ? scatterMaxTime + 20 : undefined,
                            grid: { color: '#f3f4f6', drawBorder: false },
                            ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af',
                                    callback: v => v + 's' },
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        datalabels: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleFont: { size: 11, weight: 'bold' },
                            bodyFont: { size: 11 },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                title: items => scatterLabels[items[0].parsed.x] ?? '',
                                label: item => {
                                    if (item.datasetIndex === 1) {
                                        return ` MA ${MA_WINDOW}: ${item.parsed.y.toFixed(2)}s`;
                                    }
                                    const d = scatterRaw[item.parsed.x];
                                    return ` ${d.sensor} · ${item.parsed.y.toFixed(2)}s  ${item.parsed.y > scatterScl ? '⚠ Abnormal' : '✓ Normal'}`;
                                }
                            }
                        },
                        annotation: {
                            annotations: {
                                uclScatter: {
                                    type: 'line',
                                    yMin: scatterMaxTime,
                                    yMax: scatterMaxTime,
                                    borderColor: 'rgba(239,68,68,0.85)',
                                    borderWidth: 2,
                                    label: {
                                        display: false,
                                        content: 'UCL ' + scatterMaxTime + 's',
                                        position: 'end',
                                        backgroundColor: 'rgba(239,68,68,0.85)',
                                        color: '#fff',
                                        font: { size: 10, weight: 'bold' },
                                        padding: { x: 8, y: 4 },
                                        borderRadius: 6,
                                    }
                                },
                                lclScatter: {
                                    type: 'line',
                                    yMin: scatterMinTime,
                                    yMax: scatterMinTime,
                                    borderColor: 'rgba(239,68,68,0.85)',
                                    borderWidth: 2,
                                    label: {
                                        display: false,
                                        content: 'LCL ' + scatterMinTime + 's',
                                        position: 'end',
                                        backgroundColor: 'rgba(239,68,68,0.85)',
                                        color: '#fff',
                                        font: { size: 10, weight: 'bold' },
                                        padding: { x: 8, y: 4 },
                                        borderRadius: 6,
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
        @endif

        // ─── Hourly Summary Charts ─────────────────────────────────────────
        const summaryChartData = @json($summaryData);
        const tactTimeScl = {{ $filterPattern?->cycle_time ?? 0 }};
        const summaryMaxTime = {{ $filterPattern?->max_time ?? 0 }};

        summaryChartData.forEach((summary, index) => {
            const canvas = document.getElementById(`chart_summary_${index}`);
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            const summaryLabels = Object.keys(summary.jam).map(j => `Jam ke-${j}`);
            const avgValues = Object.values(summary.jam).map(v => v.avg || 0);

            const barBgColors = avgValues.map(v => v > tactTimeScl ? 'rgba(239, 68, 68, 0.5)' : 'rgba(14, 165, 233, 0.5)');
            const barBdColors = avgValues.map(v => v > tactTimeScl ? 'rgba(239, 68, 68, 1)' : 'rgba(14, 165, 233, 1)');

            new CdnChart(ctx, {
                type: 'bar',
                data: {
                    labels: summaryLabels,
                    datasets: [{
                        label: 'Avg Cycle Time (s)',
                        data: avgValues,
                        backgroundColor: barBgColors,
                        borderColor: barBdColors,
                        borderWidth: 2,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' }, color: '#6b7280' }
                        },
                        y: {
                            beginAtZero: true,
                            max: summaryMaxTime > 0 ? summaryMaxTime + 5 : undefined,
                            grid: { color: '#f3f4f6' },
                            ticks: { font: { size: 11 }, callback: v => v + 's' }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            padding: 10,
                            titleFont: { size: 12 },
                            bodyFont: { size: 12, weight: 'bold' },
                            displayColors: false,
                            callbacks: {
                                label: function(item) {
                                    return ` Avg: ${item.parsed.y}s`;
                                }
                            }
                        },
                        annotation: {
                            annotations: {
                                sclLine: {
                                    type: 'line',
                                    yMin: tactTimeScl,
                                    yMax: tactTimeScl,
                                    borderColor: 'rgba(239,68,68,0.85)',
                                    borderWidth: 2,
                                    borderDash: [6, 4],
                                    label: {
                                        display: true,
                                        content: 'SCL ' + tactTimeScl + 's',
                                        position: 'start',
                                        backgroundColor: 'rgba(239,68,68,0.85)',
                                        color: '#fff',
                                        font: { size: 10, weight: 'bold' },
                                        padding: { x: 6, y: 4 },
                                        borderRadius: 4
                                    }
                                }
                            }
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
