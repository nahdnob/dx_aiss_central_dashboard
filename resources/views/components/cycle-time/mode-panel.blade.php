@props(['patterns', 'activePattern' => null])

@php
    $labelClass = 'block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5 ml-1';
    $boxClass   = 'border border-gray-200 rounded-lg px-4 py-2 text-sm bg-gray-50';
@endphp

{{-- Quick control mode (pattern) + info mode aktif, full width (gaya sama dengan filter Historical Report) --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-200 shadow-sm p-5']) }}>
    <div class="flex flex-wrap items-end justify-between gap-4">
        {{-- Ubah mode (hanya admin & leader) --}}
        @if (in_array(auth()->user()?->role, ['admin', 'leader']))
        <form action="{{ route('pattern-histories.store') }}" method="POST" class="flex flex-wrap items-end gap-4">
            @csrf
            <input type="hidden" name="line_id" value="{{ session('selected_line_id') }}">
            <div class="min-w-[220px]">
                <label for="mode-panel-pattern" class="{{ $labelClass }}">Mode</label>
                <select id="mode-panel-pattern" name="pattern" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                    @foreach ($patterns as $pattern)
                        <option value="{{ $pattern->id }}" @selected($activePattern?->id == $pattern->id)>
                            {{ $pattern->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">
                Apply
            </button>
        </form>
        @endif

        {{-- Info mode aktif --}}
        <div class="flex flex-wrap items-end gap-4">
            <div class="min-w-[140px]">
                <p class="{{ $labelClass }}">Active Mode</p>
                <p class="{{ $boxClass }} font-bold text-gray-900">{{ $activePattern->name ?? '-' }}</p>
            </div>
            <div class="min-w-[100px]">
                <p class="{{ $labelClass }}">SCL</p>
                <p class="{{ $boxClass }} font-bold text-red-600">{{ $activePattern->cycle_time ?? '-' }}s</p>
            </div>
            <div class="min-w-[140px]">
                <p class="{{ $labelClass }}">LCL / UCL</p>
                <p class="{{ $boxClass }} font-bold text-gray-700">{{ $activePattern->min_time ?? '-' }}s / {{ $activePattern->max_time ?? '-' }}s</p>
            </div>
        </div>
    </div>
</div>
