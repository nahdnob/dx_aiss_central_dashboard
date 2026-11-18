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
                    <img class="w-full h-full object-cover"
                        src="{{ asset('assets/images/stopwatch.jpg') }}"
                        alt="Cycle Time Monitoring">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
                </div>
                {{-- Decorative Right Background --}}
                <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-red-50 to-transparent z-20"></div>
                {{-- Decorative Glow Circle --}}
                <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-red-500/10 blur-3xl z-30"></div>
                {{-- Title & Description --}}
                <div class="relative z-40 flex flex-col lg:flex-row lg:items-center justify-between gap-4 px-8 py-5 pl-[380px] min-h-[140px]">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">CYCLE TIME MONITORING</h1>
                        <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-lg">
                            Real-time sensor performance &amp; cycle efficiency for
                            <span class="font-semibold text-red-600">AISS production line</span>.
                        </p>
                    </div>
                    {{-- Select Mode + Quick Info --}}
                    <x-cycle-time.mode-switcher :patterns="$patterns" :active-pattern="$activePattern" />
                </div>
            </div>
            <!-- Tambahkan tampilan nya disini -->
            {{-- ===== MAIN GRID ===== --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
                {{-- Chart Card (2/3 width) --}}
                <x-cycle-time.realtime-chart
                    class="xl:col-span-2"
                    :data="$realtimeData"
                    :active-pattern="$activePattern"
                />
                {{-- Logs Card (1/3 width) --}}
                <x-cycle-time.activity-log class="xl:col-span-1" :logs="$recentActivity['logs']" :total="$recentActivity['total']" />
            </div>
            {{-- ===== HISTORICAL REPORT & FILTER ===== --}}
            <div class="mb-6">
                <div class="flex items-end justify-between mb-3">
                    <div class="ml-2">
                        <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Analysis Data</p>
                        <h2 class="text-xl font-bold text-slate-700">Historical Report & Trend Monitoring</h2>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">
                    <form method="GET" action="{{ route('cycletimes.monitoring.index') }}" class="flex flex-wrap items-end justify-between gap-4">
                        <div class="flex flex-wrap items-end gap-4 flex-1">
                            {{-- Date Input --}}
                            <div class="min-w-[150px]">
                                <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5 ml-1">Date</label>
                                <input class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                    type="date"
                                    name="date"
                                    value="{{ $filterDate }}"
                                    required >
                            </div>
                            {{-- Shift Select --}}
                            <div class="min-w-[200px]">
                                <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5 ml-1">Shift</label>
                                <select name="shift_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition" required>
                                    <option value="">-- Select Shift --</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ $filterShiftId == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->name }} ({{ \Carbon\Carbon::parse($shift->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->time_end)->format('H:i') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Pattern Select --}}
                            <div class="min-w-[200px]">
                                <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5 ml-1">Pattern</label>
                                <select name="pattern_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition" required>
                                    <option value="">-- Select Pattern --</option>
                                    @foreach($patterns as $pattern)
                                        <option value="{{ $pattern->id }}" {{ $filterPatternId == $pattern->id ? 'selected' : '' }}>
                                            {{ $pattern->name }}
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
                            <a class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:brightness-110 text-white text-sm font-bold rounded-xl shadow-sm transition uppercase"
                            href="{{ route('cycletimes.monitoring.export-csv', ['date' => $filterDate, 'shift_id' => $filterShiftId, 'pattern_id' => $filterPatternId]) }}"
                            title="Export to CSV"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>CSV</span>
                            </a>
                            <a class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:brightness-110 text-white text-sm font-bold rounded-xl shadow-sm transition uppercase"
                                href="{{ route('cycletimes.monitoring.export-pdf', ['date' => $filterDate, 'shift_id' => $filterShiftId, 'pattern_id' => $filterPatternId]) }}"
                                title="Export to PDF"
                                target="_blank"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span>PDF</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            {{-- ===== TREND CYCLETIME ===== --}}
            <x-cycle-time.trend-chart class="mb-6" :data="$scatterData" :pattern="$filterPattern" />
            {{-- ===== HOURLY SUMMARY ===== --}}
            <div class="flex items-end justify-between mb-3">
                <div class="ml-2">
                    <h2 class="text-xl font-bold text-slate-700">Hourly Summary</h2>
                </div>
            </div>
            <div class="space-y-6">
                @forelse ($summaryData as $i => $summary)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                            <h4 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                <span class="text-sm font-bold text-slate-700 uppercase">
                                    POS {{ substr($summary['sensor_name'], -1) }} - {{ $summary['sensor_name'] }}
                                </span>
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
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-sm font-medium">Belum ada data summary pada hari ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
        <x-layout.footer />
    </div>
@endsection

@pushOnce('scripts', 'chartjs-cdn')
    <script src="{{ asset('vendor/chartjs/chart.umd.min.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/chartjs-plugin-annotation.min.js') }}"></script>
@endPushOnce

@push('scripts')
    <script>
        const CdnChart = window.Chart;

        document.addEventListener('DOMContentLoaded', function () {
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
@endpush