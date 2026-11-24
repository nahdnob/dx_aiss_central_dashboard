{{-- Params: $patterns (wajib), $activePattern, $class --}}
@php
    $activePattern = $activePattern ?? null;
@endphp

{{-- Mode (pattern) selector + quick info SCL / LCL / UCL --}}
<div class="flex flex-wrap items-center gap-3 {{ $class ?? '' }}">
    <form action="{{ route('pattern-histories.store') }}" method="POST" class="flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl shadow-sm">
        @csrf
        <input type="hidden" name="line_id" value="{{ session('selected_line_id') }}">
        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Mode</label>
        <select name="pattern" class="bg-white border border-gray-200 text-gray-800 text-xs font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent px-2.5 py-1.5 transition-all">
            @foreach ($patterns as $pattern)
                <option value="{{ $pattern->id }}" @selected($activePattern?->id == $pattern->id)>
                    {{ $pattern->name }}
                </option>
            @endforeach
        </select>
        <button type="submit"
                class="px-4 py-1.5 bg-gradient-to-r from-red-600 to-rose-700 hover:brightness-110 text-white text-xs font-bold rounded-lg transition-all duration-200 shadow-sm whitespace-nowrap uppercase">
            Apply
        </button>
    </form>
    <div class="flex items-center gap-4 px-5 py-2.5 bg-gray-50 rounded-xl border border-gray-200 shadow-sm">
        <div class="text-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active Mode</p>
            <p class="text-xs font-bold text-gray-900 mt-0.5">{{ $activePattern->name ?? '-' }}</p>
        </div>
        <div class="w-px h-8 bg-gray-200"></div>
        <div class="text-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">SCL</p>
            <p class="text-xs font-bold text-red-600 mt-0.5">{{ $activePattern->cycle_time ?? '-' }}s</p>
        </div>
        <div class="w-px h-8 bg-gray-200"></div>
        <div class="text-center">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">LCL / UCL</p>
            <p class="text-xs font-bold text-gray-700 mt-0.5">{{ $activePattern->min_time ?? '-' }}s / {{ $activePattern->max_time ?? '-' }}s</p>
        </div>
    </div>
</div>
