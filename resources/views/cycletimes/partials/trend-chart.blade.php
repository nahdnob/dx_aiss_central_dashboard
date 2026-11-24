{{-- Params: $data (wajib), $pattern, $chartId, $height, $fill, $class --}}
@php
    $pattern = $pattern ?? null;
    $chartId = $chartId ?? 'scatterChart';
    $height  = $height ?? 'h-96';
    $fill    = $fill ?? false; // true: chart mengisi tinggi card (card diberi tinggi dari luar)
@endphp

{{-- Cycle Time Trend: scatter seluruh pembacaan sensor + moving average, dengan garis UCL/LCL --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col {{ $class ?? '' }}">
    <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0">
        <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
            <span class="text-sm font-bold text-slate-700 uppercase">Cycle Time Trend</span>
        </h3>
        <div class="flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span> Normal</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400 inline-block"></span> Abnormal</span>
            <span class="flex items-center gap-1.5"><span class="w-6 border-t-2 border-red-500 inline-block"></span> UCL</span>
            <span class="flex items-center gap-1.5"><span class="w-6 border-t-2 border-amber-500 inline-block"></span> LCL</span>
        </div>
    </div>
    <div @class(['p-4 flex-1 min-h-0 flex flex-col' => $fill, 'p-6' => !$fill])>
        @if (count($data) > 0)
        <div @class(['relative w-full', 'flex-1 min-h-0' => $fill, $height => !$fill])>
            <canvas id="{{ $chartId }}"></canvas>
        </div>
        @else
        <div @class(['flex flex-col items-center justify-center text-gray-400', 'flex-1' => $fill, 'h-64' => !$fill])>
            <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="6" cy="6" r="1.5" fill="currentColor"/><circle cx="12" cy="10" r="1.5" fill="currentColor"/><circle cx="18" cy="4" r="1.5" fill="currentColor"/></svg>
            <p class="text-sm italic">No data to plot for the selected period.</p>
        </div>
        @endif
    </div>
</div>

@pushOnce('scripts', 'chartjs-cdn')
    <script src="{{ asset('vendor/chartjs/chart.umd.min.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/chartjs-plugin-annotation.min.js') }}"></script>
@endPushOnce

@if (count($data) > 0)
    @push('scripts')
        <script>
            (function () {
                const CdnChart = window.Chart;

                document.addEventListener('DOMContentLoaded', function () {
                    // ─── Scatter Chart ───────────────────────────────────────────────
                    const scatterCtx = document.getElementById(@json($chartId))?.getContext('2d');
                    if (scatterCtx) {
                        const scatterRaw   = @json($data);
                        const scatterScl   = {{ $pattern?->cycle_time ?? 0 }};
                        const scatterMaxTime = {{ $pattern?->max_time ?? 0 }};
                        const scatterMinTime = {{ $pattern?->min_time ?? 0 }};
                        const scatterLabels = scatterRaw.map(d => d.x);
                        const scatterPoints = scatterRaw.map((d, i) => ({ x: i, y: Number(d.y) }));
                        const scatterColors = scatterRaw.map(d => d.status == 1
                            ? 'rgba(34,197,94,0.65)'
                            : 'rgba(239,68,68,0.75)');

                        // ── Moving Average ──
                        const MA_WINDOW = 100; // jumlah titik per rata-rata, ubah sesuai kebutuhan

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
                                        max: scatterMaxTime > 0 ? scatterMaxTime + 10 : undefined,
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
                                                return ` ${d.pos ?? d.sensor} · ${item.parsed.y.toFixed(2)}s  ${item.parsed.y > scatterScl ? '⚠ Abnormal' : '✓ Normal'}`;
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
                });
            })();
        </script>
    @endpush
@endif
