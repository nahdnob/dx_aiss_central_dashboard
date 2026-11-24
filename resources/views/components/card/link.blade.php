@props([
    'href',
    'eyebrow',
    'title',
    'description' => null,
    'color'       => 'indigo', {{-- indigo | cyan | rose --}}
])

@php
    $colors = [
        'indigo' => [
            'card'  => 'hover:border-indigo-200',
            'blob'  => 'bg-indigo-50 group-hover:bg-indigo-100',
            'icon'  => 'bg-indigo-100 group-hover:bg-indigo-200 text-indigo-600',
            'arrow' => 'text-indigo-400',
        ],
        'cyan' => [
            'card'  => 'hover:border-cyan-200',
            'blob'  => 'bg-cyan-50 group-hover:bg-cyan-100',
            'icon'  => 'bg-cyan-100 group-hover:bg-cyan-200 text-cyan-600',
            'arrow' => 'text-cyan-400',
        ],
        'rose' => [
            'card'  => 'hover:border-rose-200',
            'blob'  => 'bg-rose-50 group-hover:bg-rose-100',
            'icon'  => 'bg-rose-100 group-hover:bg-rose-200 text-rose-600',
            'arrow' => 'text-rose-400',
        ],
    ];

    $c = $colors[$color];
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => "group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 {$c['card']}"]) }}>
    {{-- Decorative --}}
    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full transition-colors {{ $c['blob'] }}"></div>
    {{-- Content --}}
    <div class="relative flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors {{ $c['icon'] }}">
            {{ $slot }}
        </div>
        <div>
            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">{{ $eyebrow }}</p>
            <p class="text-base font-bold text-gray-900">{{ $title }}</p>
            @if ($description)
                <p class="text-xs text-gray-500 mt-0.5">{{ $description }}</p>
            @endif
        </div>
    </div>
    {{-- Arrow --}}
    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
        <svg class="w-4 h-4 {{ $c['arrow'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
    </div>
</a>
