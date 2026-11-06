@props(['paginator', 'label' => 'item'])

@php
    $current = $paginator->currentPage();
    $last    = $paginator->lastPage();
    $start   = max(1, $current - 2);
    $end     = min($last, $current + 2);
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-between px-5 py-3 border-t border-gray-100']) }}>
    <p class="text-xs text-slate-400 font-medium">
        Showing {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}
        of {{ $paginator->total() }} {{ \Illuminate\Support\Str::plural($label, $paginator->total()) }}
    </p>

    @if ($paginator->hasPages())
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">‹</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">‹</a>
            @endif

            {{-- Halaman pertama --}}
            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}"
                   class="px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">1</a>
                @if ($start > 2)
                    <span class="px-1 text-xs text-gray-400">…</span>
                @endif
            @endif

            {{-- Nomor di sekitar halaman aktif --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page === $current)
                    <span class="px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg shadow-sm">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->url($page) }}"
                       class="px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">{{ $page }}</a>
                @endif
            @endfor

            {{-- Halaman terakhir --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="px-1 text-xs text-gray-400">…</span>
                @endif
                <a href="{{ $paginator->url($last) }}"
                   class="px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">{{ $last }}</a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">›</a>
            @else
                <span class="px-3 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">›</span>
            @endif
        </div>
    @endif
</div>