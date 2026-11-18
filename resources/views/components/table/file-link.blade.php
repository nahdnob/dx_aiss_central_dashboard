@props(['path' => null])

@if ($path)
    <a href="{{ \Illuminate\Support\Facades\Storage::url($path) }}" target="_blank" rel="noopener"
       class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-800 break-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Open File
    </a>
@else
    <span class="text-sm text-gray-400">No file</span>
@endif
