@props([
    'data',
    'activePattern' => null,
    'chartId'       => 'realtimeChart',
    'fill'          => false, // true: chart mengisi tinggi card (card diberi tinggi dari luar)
])

{{-- Real-time Performance Chart: rata-rata cycle time per sensor hari ini untuk mode aktif --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden h-full flex flex-col']) }}>
    <div class="px-4 py-3 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3 shrink-0">
        <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
            <span class="text-sm font-bold text-slate-700 uppercase">Real-time Performance Chart</span>
        </h3>
        <div class="flex items-center gap-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-emerald-400 inline-block"></span>
                <span>Normal</span>
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-red-400 inline-block"></span>
                <span>Abnormal</span>
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-6 border-t-2 border-dashed border-red-500 inline-block"></span>
                <span>SCL</span>
            </span>
        </div>
    </div>

    {{-- Konten tambahan opsional (mis. mode switcher) --}}
    @if (!$slot->isEmpty())
        <div class="px-4 py-2 border-b border-gray-100 bg-gray-50/40 shrink-0">
            {{ $slot }}
        </div>
    @endif

    <div @class(['flex-1 flex flex-col justify-center', 'p-4 min-h-0' => $fill, 'p-6' => !$fill])>
        @if (count($data) > 0)
            <div @class(['relative w-full', 'flex-1 min-h-0' => $fill, 'h-80' => !$fill])>
                <canvas id="{{ $chartId }}"></canvas>
            </div>
        @else
            <div @class(['flex flex-col items-center justify-center text-gray-400', 'flex-1' => $fill, 'h-80' => !$fill])>
                <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <p class="text-sm italic">No realtime data available yet.</p>
                <p class="text-xs mt-1">Waiting for active pattern data...</p>
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
                    const canvas = document.getElementById(@json($chartId));
                    if (!canvas) return;

                    const labels        = @json(collect($data)->pluck('label'));
                    const durations     = @json(collect($data)->pluck('duration'));
                    const activeScl     = {{ $activePattern?->cycle_time ?? 0 }};
                    const activeMaxTime = {{ $activePattern?->max_time ?? 0 }};

                    // Tampilkan nilai cycle time di tengah setiap bar
                    const barValueLabels = {
                        id: 'barValueLabels',
                        afterDatasetsDraw(chart) {
                            const { ctx } = chart;
                            const meta = chart.getDatasetMeta(0);
                            ctx.save();
                            ctx.font = 'bold 11px sans-serif';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillStyle = '#ffffff';
                            meta.data.forEach((bar, i) => {
                                const value = durations[i];
                                if (value === null || value === undefined) return;
                                // Lewati bar yang terlalu pendek untuk memuat teks
                                if (bar.base - bar.y < 18) return;
                                ctx.fillText(Number(value).toFixed(1) + 's', bar.x, (bar.y + bar.base) / 2);
                            });
                            ctx.restore();
                        }
                    };

                    new CdnChart(canvas.getContext('2d'), {
                        type: 'bar',
                        plugins: [barValueLabels],
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
                                barPercentage: 0.9,
                                categoryPercentage: 0.9,
                                maxBarThickness: 72,
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
                                    ticks: { font: { size: 10, weight: 'bold' }, color: '#9ca3af', callback: v => v + 's' },
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { font: { size: 10, weight: '600' }, color: '#4b5563' }
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                datalabels: { display: false },
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
                });
            })();
        </script>
    @endpush
@endif
