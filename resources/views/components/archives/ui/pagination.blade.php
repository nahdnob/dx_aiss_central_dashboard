@props(['paginator'])

@if ($paginator->hasPages())
    <nav>
        <div class="inline-flex rounded-base shadow-xs -space-x-px">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center border text-gray-400 cursor-not-allowed">
                    ‹
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                class="w-9 h-9 flex items-center justify-center border hover:bg-gray-200">
                    ‹
                </a>
            @endif
            {{-- Page Info --}}
            <span class="px-4 h-9 flex items-center justify-center border bg-gray-100">
                {{ $paginator->currentPage() }}
                of
                {{ $paginator->lastPage() }}
            </span>
            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center border hover:bg-gray-200">
                    ›
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center border text-gray-400 cursor-not-allowed">
                    ›
                </span>
            @endif
        </div>
    </nav>
@endif