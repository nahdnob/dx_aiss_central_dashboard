@php
    // Compact: 4 card dalam satu baris (dashboard / Home). Dibaca juga dari query
    // ?compact=1 supaya tetap compact saat konten di-refresh oleh x-auto-refresh.
    $compact = $compact ?? request()->boolean('compact');

    $cards = [
        [
            'label' => 'Part No. Sub Assy',
            'value' => $subAssyPartNumber ?? '-',
            'color' => 'neutral',
            'icon'  => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        ],
        [
            'label' => 'Part No. Final Assy',
            'value' => $finalAssyPartNumber ?? '-',
            'color' => 'neutral',
            'icon'  => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
        ],
        [
            'label' => 'WIP',
            'value' => $wip . ' / ' . $wipCapacity,
            'color' => 'neutral',
            'icon'  => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
        ],
        [
            'label' => 'Status WIP',
            'value' => $wipAbnormal ? 'ABNORMAL' : 'NORMAL',
            'color' => $wipAbnormal ? 'red' : 'green',
            'icon'  => $wipAbnormal
                ? 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
                : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    ];

    // Full class names listed so Tailwind can detect them
    $palette = [
        'neutral' => ['bubble' => 'bg-gray-50 group-hover:bg-gray-100', 'box' => 'bg-gray-100', 'icon' => 'text-gray-700', 'text' => 'text-gray-900'],
        'green'   => ['bubble' => 'bg-green-50 group-hover:bg-green-100',   'box' => 'bg-green-100',  'icon' => 'text-green-600',  'text' => 'text-green-600'],
        'red'     => ['bubble' => 'bg-red-50 group-hover:bg-red-100',       'box' => 'bg-red-100',    'icon' => 'text-red-600',    'text' => 'text-red-600'],
    ];
@endphp

@php
    $ui = $compact
        ? [
            'grid'  => 'grid grid-cols-2 xl:grid-cols-4 gap-3',
            'card'  => 'px-3 py-2.5',
            'gap'   => 'gap-2.5',
            'box'   => 'w-9 h-9 rounded-lg',
            'svg'   => 'w-5 h-5',
            'label' => 'text-[9px] tracking-wider',
            'value' => 'mt-0.5 text-base 2xl:text-xl',
        ]
        : [
            'grid'  => 'grid grid-cols-1 sm:grid-cols-2 min-[1700px]:grid-cols-4 gap-4',
            'card'  => 'px-4 py-3',
            'gap'   => 'gap-3',
            'box'   => 'w-11 h-11 rounded-xl',
            'svg'   => 'w-6 h-6',
            'label' => 'text-[10px] tracking-widest',
            'value' => 'mt-1 text-2xl',
        ];
@endphp

<div class="{{ $ui['grid'] }}">
    @foreach ($cards as $card)
        @php $c = $palette[$card['color']]; @endphp
        <div class="relative bg-white rounded-2xl border border-gray-200 shadow-sm {{ $ui['card'] }} flex items-center overflow-hidden group hover:shadow-md transition-shadow duration-200">
            <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full {{ $c['bubble'] }} transition-colors"></div>
            <div class="relative w-full flex items-center {{ $ui['gap'] }}">
                <div class="{{ $ui['box'] }} {{ $c['box'] }} flex items-center justify-center shrink-0">
                    <svg class="{{ $ui['svg'] }} {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="{{ $ui['label'] }} font-bold text-gray-400 uppercase whitespace-nowrap truncate">{{ $card['label'] }}</p>
                    <p class="{{ $ui['value'] }} font-extrabold tracking-tight truncate {{ $c['text'] }}" title="{{ $card['value'] }}">{{ $card['value'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
