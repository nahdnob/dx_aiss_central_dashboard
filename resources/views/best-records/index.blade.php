@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">
        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Trophy Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/trophy.jpg') }}" alt="Best Record" class="w-full h-full object-cover">
                {{-- Fade ke tengah --}}
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
            </div>
            {{-- Decorative Right Background --}}
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-red-50 to-transparent z-20"></div>
            {{-- Decorative Glow Circle --}}
            <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-red-500/10 blur-3xl z-30"></div>
            {{-- Decorative Small Circle --}}
            <div class="absolute right-20 top-1/2 -translate-y-1/2 w-24 h-24 rounded-full bg-red-100/50 z-30"></div>
            {{-- Content --}}
            <div class="relative z-40 px-8 py-5 pl-[380px] min-h-[140px] flex flex-col justify-center">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">BEST RECORDS</h1>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    This is the history of claims that have occurred on the
                    <span class="font-semibold text-red-600">AISS production line</span>.
                    Precision tracking ensures continuous improvement and technical accountability across all industrial operations.
                </p>
            </div>
        </div>
        {{-- ===== OPERATIONS INPUT SECTION ===== --}}
        <div class="mb-6">
            {{-- Title --}}
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Operations Input</p>
                <h2 class="text-xl font-bold text-gray-900">New Claim Entry</h2>
            </div>
            {{-- Form --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <form action="{{ route('best-records.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3 items-end">
                        {{-- Date --}}
                        <div class="flex-1 min-w-0">
                            <label for="date" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Occurrence Date</label>
                            <input
                                type="date"
                                name="date"
                                id="date"
                                value="{{ old('date') }}"
                                required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                            >
                        </div>
                        {{-- Claim Description --}}
                        <div class="flex-[2] min-w-0">
                            <label for="claim" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Claim Description</label>
                            <input
                                type="text"
                                name="claim"
                                id="claim"
                                value="{{ old('claim') }}"
                                placeholder="Specify technical issue..."
                                required
                                class="placeholder:text-zinc-300 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                            >
                        </div>
                        {{-- Action Taken --}}
                        <div class="flex-[2] min-w-0">
                            <label for="action" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Action Taken</label>
                            <input
                                type="text"
                                name="action"
                                id="action"
                                value="{{ old('action') }}"
                                placeholder="Resolution status..."
                                required
                                class="placeholder:text-zinc-300 w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                            >
                        </div>
                        {{-- Submit --}}
                        <div class="shrink-0 w-full sm:w-auto">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:brightness-110 text-white font-bold text-sm px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200 whitespace-nowrap uppercase">
                                Submit Record
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- ===== AUDIT LOG / CLAIM HISTORY ===== --}}
        <div>
            <div class="flex items-end justify-between mb-3">
                {{-- Title --}}
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Audit Log</p>
                    <h2 class="text-xl font-bold text-gray-900">Claim History</h2>
                </div>
                <div class="flex items-center gap-2">
                    {{-- BUtton Filter --}}
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M7 10h10M11 16h2"/>
                        </svg>
                    </button>
                    {{-- Button Export --}}
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                        </svg>
                    </button>
                </div>
            </div>
            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Search bar + Add Data --}}
                <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form id="machine-search-form" method="GET" action="{{ route('best-records.index') }}" class="flex items-center gap-2 flex-1 max-w-lg">
                        {{-- Search Input --}}
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search claim..."
                                   class="placeholder:text-zinc-300 block w-full pl-9 pr-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"/>
                        </div>
                        {{-- Button Search --}}
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">
                            Search
                        </button>
                        {{-- Button Reset --}}
                        @if(request('search'))
                            <a href="{{ route('best-records.index') }}" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition shrink-0 uppercase">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
                <table class="w-full text-sm text-left">
                    {{-- Table Header --}}
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-150 text-center text-gray-500 font-bold text-[10px] tracking-widest uppercase">
                            <th class="px-5 py-3">Date</th>
                            <th class="px-5 py-3">Claim</th>
                            <th class="px-5 py-3">Action</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($ncds as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                                {{-- Date + ID --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="font-semibold text-gray-800 text-sm">
                                        {{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}
                                    </div>
                                    <div class="text-[11px] text-gray-400 mt-0.5">ID: REC-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                {{-- Claim --}}
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $item->claim }}
                                </td>
                                {{-- Action --}}
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $item->action }}
                                </td>
                                {{-- Edit/Delete --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Edit / Delete (visible on hover) --}}
                                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                            <a href="javascript:void(0)"
                                                data-modal-open="edit-best-records-modal-{{ $item->id }}"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-500 text-white hover:bg-sky-600 transition shadow-sm"
                                                title="Edit"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('best-records.destroy', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Hapus record ini?')"
                                                    title="Delete"
                                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 transition shadow-sm"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {{-- Edit Modal --}}
                            <x-ui.modal id="edit-best-records-modal-{{ $item->id }}" maxWidth="max-w-lg">
                                <x-forms.edit-best-record :item="$item" />
                            </x-ui.modal>
                        @empty
                            {{-- Empty State --}}
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center bg-white">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <span class="text-sm">Belum ada data claim yang tercatat.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>    
                {{-- Table - Footer --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                    {{-- Pagination --}}
                    <p class="text-xs text-slate-400 font-medium">
                        Showing {{ $ncds->firstItem() ?? 0 }}–{{ $ncds->lastItem() ?? 0 }} of {{ $ncds->total() }} claims recorded
                    </p>
                    <div class="flex items-center gap-2">
                        {{-- Previous --}}
                        @if ($ncds->onFirstPage())
                            <span class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $ncds->previousPageUrl() }}"
                               class="px-4 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Previous
                            </a>
                        @endif
                        {{-- Next --}}
                        @if ($ncds->hasMorePages())
                            <a href="{{ $ncds->nextPageUrl() }}"
                               class="px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg hover:brightness-110 shadow-sm shadow-sky-200 transition">
                                Next
                            </a>
                        {{-- Empty State --}}
                        @else
                            <span class="px-4 py-1.5 text-xs font-bold text-white bg-sky-300 rounded-lg cursor-not-allowed">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer --}}
    <x-ui.footer />
</div>
@endsection
