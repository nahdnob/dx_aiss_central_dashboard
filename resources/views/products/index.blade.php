@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">
        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Production Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/production.jpg') }}" alt="Production" class="w-full h-full object-cover">
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
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">PRODUCTION</h1>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    Real-time monitoring of product flow on the
                    <span class="font-semibold text-red-600">AISS production line</span>.
                    Track part numbers, quantities, and timestamps across all input/output points.
                </p>
            </div>
        </div>
        {{-- ===== SUMMARY CARDS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            {{-- Total Products --}}
            <div class="relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden group hover:shadow-md transition-shadow duration-200">
                <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full bg-sky-50 group-hover:bg-sky-100 transition-colors"></div>
                <div class="relative flex items-center gap-4">
                    {{-- Icon --}}
                    <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    {{-- Title and Description --}}
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Total Part Number</p>
                        <p class="text-2xl font-extrabold text-gray-900">
                            {{ $products->total() }}
                        </p>
                    </div>
                </div>
            </div>
            {{-- Total QTY In --}}
            <div class="relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden group hover:shadow-md transition-shadow duration-200">
                <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full bg-green-50 group-hover:bg-green-100 transition-colors"></div>
                <div class="relative flex items-center gap-4">
                    {{-- Icon --}}
                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16l4-4m0 0l4 4m-4-4v12M21 8l-4 4m0 0l-4-4m4 4V0"/>
                        </svg>
                    </div>
                    {{-- Title and Description --}}
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Total QTY In</p>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $products->sum('quantity') ?? 0 }}</p>
                    </div>
                </div>
            </div>
            {{-- Total QTY Out --}}
            <div class="relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden group hover:shadow-md transition-shadow duration-200">
                <div class="absolute -top-4 -right-4 w-16 h-16 rounded-full bg-red-50 group-hover:bg-red-100 transition-colors"></div>
                <div class="relative flex items-center gap-4">
                    {{-- Icon --}}
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>
                    {{-- Title and Description --}}
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Total QTY Out</p>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $products->sum('qty_out') ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- ===== PRODUCTION MONITORING ===== --}}
        <div class="mb-6">
            <div class="flex items-end justify-between mb-3">
                {{-- Title and Description --}}
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Production Monitoring</p>
                    <h2 class="text-xl font-bold text-gray-900">Production Progress</h2>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Button Filter --}}
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
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Table --}}
                <table class="w-full text-sm text-left">
                    {{-- Table Header --}}
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Part Number</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Time In</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">QTY In</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Time Out</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">QTY Out</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase text-right">Flow</th>
                        </tr>
                    </thead>
                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($products as $item)
                            @php
                                $timeIn  = $item->firstProductIn['time_in'] ?? null;
                                $timeOut = $item->lastProductIn->productOut->time_out ?? null;
                                $qtyIn   = $item->qty_in ?? 0;
                                $qtyOut  = $item->qty_out ?? 0;
                                $flowPct = $qtyIn > 0 ? round(($qtyOut / $qtyIn) * 100, 1) : 0;
                            @endphp
                            <tr class="hover:bg-red-50/40 transition-colors duration-150 group">
                                {{-- Part Number --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-gray-800 text-sm">{{ $item->part_number }}</span>
                                    </div>
                                </td>
                                {{-- Time In --}}
                                <td class="px-5 py-4 text-gray-600 text-sm">
                                    @if($timeIn)
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                            {{ \Carbon\Carbon::parse($timeIn)->format('Y-m-d H:i') }}
                                        </div>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                {{-- QTY In --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-green-100 text-green-700">
                                        {{ $qtyIn ?: '—' }}
                                    </span>
                                </td>
                                {{-- Time Out --}}
                                <td class="px-5 py-4 text-gray-600 text-sm">
                                    @if($timeOut)
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                            {{ \Carbon\Carbon::parse($timeOut)->format('Y-m-d H:i') }}
                                        </div>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                {{-- QTY Out --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-sky-100 text-sky-700">
                                        {{ $qtyOut ?: '—' }}
                                    </span>
                                </td>
                                {{-- Flow donut --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="relative w-8 h-8 shrink-0">
                                            {{-- Donut ring --}}
                                            <div class="w-8 h-8 rounded-full"
                                                 style="background: conic-gradient(
                                                    {{ $flowPct >= 100 ? '#22c55e' : '#3b82f6' }} 0deg,
                                                    {{ $flowPct >= 100 ? '#22c55e' : '#3b82f6' }} {{ min($flowPct, 100) * 3.6 }}deg,
                                                    #f3f4f6 {{ min($flowPct, 100) * 3.6 }}deg,
                                                    #f3f4f6 360deg
                                                 );">
                                                {{-- Donut hole (Inner white circle) --}}
                                                <div class="absolute inset-[2.5px] rounded-full bg-white"></div>
                                            </div>
                                        </div>
                                        {{-- Flow Percentage --}}
                                        <span class="text-[11px] font-bold {{ $flowPct >= 100 ? 'text-green-600' : 'text-sky-600' }}">{{ $flowPct }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- Empty State --}}
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        <span class="text-sm">No productions data yet.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Footer Pagination --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                    <p class="text-xs text-red-500 font-medium">
                        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} parts
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($products->onFirstPage())
                            <span class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}"
                               class="px-4 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Previous
                            </a>
                        @endif
                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}"
                               class="px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-red-600 to-rose-700 rounded-lg hover:brightness-110 shadow-sm shadow-red-200 transition">
                                Next
                            </a>
                        @else
                            <span class="px-4 py-1.5 text-xs font-bold text-white bg-red-300 rounded-lg cursor-not-allowed">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        {{-- ===== DATA TABLE ===== --}}
        <div>
            <div class="flex items-end justify-between mb-3">
                {{-- Title and Description --}}
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Production Data</p>
                    <h2 class="text-xl font-bold text-gray-900">Part Tracking</h2>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Button Filter --}}
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
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Search bar --}}
                <div class="p-4 border-b border-gray-100">
                    <form id="product-search-form" method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
                        {{-- Search Input --}}
                        <div class="relative flex-1 max-w-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input class="placeholder:text-gray-400 block w-full pl-9 pr-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="search"
                                id          ="search"
                                name        ="search"
                                value       ="{{ request('search') }}"
                                placeholder ="Search part number..."/>
                        </div>
                        {{-- Button Search --}}
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">
                            Search
                        </button>
                        {{-- Button Reset --}}
                        @if(request('search'))
                            <a href="{{ route('products.index') }}" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
                {{-- Table --}}
                <table class="w-full text-sm text-left">
                    {{-- Table Header --}}
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">PCB ID</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Part Number</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Time In</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Kanban ID</th>
                            <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Time Out</th>
                        </tr>
                    </thead>
                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($datas as $item)
                            <!-- @php
                                $timeIn  = $item->firstProductIn['time_in'] ?? null;
                                $timeOut = $item->lastProductIn->productOut->time_out ?? null;
                                $qtyIn   = $item->qty_in ?? 0;
                                $qtyOut  = $item->qty_out ?? 0;
                                $flowPct = $qtyIn > 0 ? round(($qtyOut / $qtyIn) * 100, 1) : 0;
                            @endphp -->
                            <tr class="hover:bg-red-50/40 transition-colors duration-150 group">
                                <!-- Part ID -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-700 text-sm">{{ $item->part_id }}</span>
                                </td>
                                <!-- Part Number -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-700 text-sm">{{ $item->part_number }}</span>
                                </td>
                                <!-- Time In -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-700 text-sm">{{ \Carbon\Carbon::parse($item->time_in)->format('Y-m-d H:i') ?? '—' }}</span>
                                </td>
                                <!-- Kanban ID -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-700 text-sm">{{ $item->productOut->tag_id ?? '-' }}</span>
                                </td>
                                <!-- Time Out -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-slate-700 text-sm">{{ $item->productOut?->time_out ? \Carbon\Carbon::parse($item->productOut->time_out)->format('Y-m-d H:i') : '-' }}</span>
                                </td>
                            </tr>
                        @empty
                            {{-- Empty State --}}
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        <span class="text-sm">No productions data yet.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Footer Pagination --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                    <p class="text-xs text-red-500 font-medium">
                        Showing {{ $datas->firstItem() ?? 0 }}–{{ $datas->lastItem() ?? 0 }} of {{ $datas->total() }} parts
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($datas->onFirstPage())
                            <span class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $datas->previousPageUrl() }}"
                               class="px-4 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Previous
                            </a>
                        @endif
                        @if ($datas->hasMorePages())
                            <a href="{{ $datas->nextPageUrl() }}"
                               class="px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-red-600 to-rose-700 rounded-lg hover:brightness-110 shadow-sm shadow-red-200 transition">
                                Next
                            </a>
                        @else
                            <span class="px-4 py-1.5 text-xs font-bold text-white bg-red-300 rounded-lg cursor-not-allowed">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-ui.footer />
</div>
@endsection
