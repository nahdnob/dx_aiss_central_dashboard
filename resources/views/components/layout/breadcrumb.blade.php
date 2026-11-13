@props(['items' => []])

<nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'flex items-center gap-3 mb-2']) }}>
    @foreach ($items as $item)
    
        @php
            $isLast = $loop->last;
            $url    = $item['url'] ?? null;
        @endphp

        @if ($url && !$isLast)
            <a href="{{ $url }}"
               class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-gray-600 transition">
                @if ($loop->first)
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                @endif
                {{ $item['label'] }}
            </a>
        @else
            <span class="text-xs font-semibold {{ $isLast ? 'text-sky-600' : 'text-gray-400' }}">
                {{ $item['label'] }}
            </span>
        @endif

        @unless ($isLast)
            <span class="text-gray-300">/</span>
        @endunless
    @endforeach
</nav>