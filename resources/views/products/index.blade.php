@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">
        {{-- ===== HERO HEADER ===== --}}
        <x-layout.page-hero title="PRODUCTION" image="assets/images/production.jpg" alt="Production">
            This is the real-time monitoring of product flow on the
            <span class="font-semibold text-red-600">AISS production line</span>.
            Track part numbers, quantities, and timestamps across all input/output points.
        </x-layout.page-hero>
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
                        <p class="text-2xl font-extrabold text-gray-900">{{ $products->sum('qty_in') ?? 0 }}</p>
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
        {{-- ===== PRODUCTION SUMMARY ===== --}}
        <x-auto-refresh :url="route('products.summary')" :interval="5000">
            @include('products.partials.summary')
        </x-auto-refresh>
        {{-- ===== PRODUCTION LOG ===== --}}
        <x-auto-refresh :url="route('products.log')" :interval="5000">
            @include('products.partials.log')
        </x-auto-refresh>
    </div>
    <x-layout.footer />
</div>
@endsection
@pushOnce('scripts')
    @vite('resources/js/entries/autoRefresh.js')
@endPushOnce
