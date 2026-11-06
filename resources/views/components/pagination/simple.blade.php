@props(['paginator', 'label' => 'item'])

<div {{ $attributes->merge(['class' => 'flex items-center justify-between px-5 py-3 border-t border-gray-100']) }}>
    <p class="text-xs text-slate-400 font-medium">
        Showing {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}
        of {{ $paginator->total() }} {{ \Illuminate\Support\Str::plural($label, $paginator->total()) }}
    </p>

    <div class="flex items-center gap-2">
        @if ($paginator->onFirstPage())
            <span class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-4 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Previous</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg hover:brightness-110 shadow-sm transition">Next</a>
        @else
            <span class="px-4 py-1.5 text-xs font-bold text-white bg-sky-300 rounded-lg cursor-not-allowed">Next</span>
        @endif
    </div>
</div>