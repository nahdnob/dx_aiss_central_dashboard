@extends('layouts.system-manager')

@push('head')
    {{-- Reload penuh tiap 60 detik agar chart cycle time ikut ter-update --}}
    <meta http-equiv="refresh" content="60">
@endpush

@section('content')
<div class="px-2 sm:ml-16 mt-16 transition-all duration-300">
    <div class="px-3 pt-3 pb-8 space-y-4">

        {{-- ===== OVERVIEW & PRODUCTION ===== --}}
        {{-- Kolom kiri lebar tetap, kolom kanan mengambil sisa ruang. Setinggi layar (xl+):
             sisa tinggi hanya diberikan ke Line Performance (kiri) dan tabel WIP (kanan). --}}
        <div class="grid grid-cols-1 xl:grid-cols-[360px_minmax(0,1fr)] 2xl:grid-cols-[400px_minmax(0,1fr)] gap-4 xl:min-h-[calc(100vh-6rem)]">
            {{-- Kolom kiri: Best Record, Line Performance, Security Rank --}}
            <div class="flex flex-col gap-4">
                <x-dashboard.best-record
                    fluid
                    class="shrink-0"
                    :day-count="$best_record['day_count']"
                    :last-day="$best_record['last_day']"
                />

                <x-dashboard.line-performance compact class="flex-1" :items="$linePerformances" />

                @if ($selectedLineId)
                    <x-dashboard.security-matrix :matrix="$matrix" class="shrink-0 !h-auto" />
                @endif
            </div>

            {{-- Kolom kanan: Production cards + Work in Progress --}}
            <div class="flex flex-col gap-4 min-w-0">
                @if ($selectedLineId)
                    <x-auto-refresh :url="route('products.stats', ['compact' => 1])" :interval="5000" class="block shrink-0">
                        @include('products.partials.stats', ['compact' => true])
                    </x-auto-refresh>

                    {{-- Area tabel: 6 baris WIP (header 56px + 6 x 74px = 500px, lihat product-table).
                         xl+: area tabel mengisi sisa tinggi card, dan tinggi tiap baris dibagi rata
                         (container query: (tinggi area - header) / 6) sehingga tidak ada ruang kosong.
                         Lebih dari 6 baris → scroll di dalam area tsb, header tabel tetap (sticky). --}}
                    <x-ui.card class="shrink-0 xl:flex-1 overflow-hidden flex flex-col">
                        <div class="px-4 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                            <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                <span class="text-sm font-bold text-slate-700 uppercase">Work in Progress</span>
                            </h3>
                            @if (in_array(auth()->user()?->role, ['admin', 'leader']))
                                <a href="{{ route('products.index') }}" class="text-xs font-bold text-red-600 hover:underline uppercase tracking-wide">
                                    View Production &rarr;
                                </a>
                            @endif
                        </div>
                        <x-auto-refresh :url="route('products.fetchTable')" :interval="10000" class="block h-[500px] overflow-auto [container-type:size] xl:h-auto xl:min-h-[500px] xl:flex-1 xl:[--wip-row-h:max(74px,calc((100cqh-56px)/6))]">
                            @include('dashboards.partials.product-table', ['products' => $products])
                        </x-auto-refresh>
                    </x-ui.card>
                @else
                    {{-- Security rank, cycle time & produksi bergantung pada line yang dipilih --}}
                    <x-ui.card class="flex-1 p-10 flex flex-col items-center justify-center text-center border-dashed">
                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-semibold text-gray-700">Select a line to see security rank, cycle time and production data.</p>
                        <a href="{{ route('line-selector.index') }}" class="mt-4 px-5 py-2 bg-gradient-to-r from-red-600 to-rose-700 hover:brightness-110 text-white text-xs font-bold rounded-lg shadow-sm uppercase">
                            Select Line
                        </a>
                    </x-ui.card>
                @endif

                {{-- Teks berjalan (sama dengan kiosk dashboard, diatur via MarqueeText) --}}
                @if (filled($marqueeText?->text))
                    <div class="shrink-0 rounded-sm border border-yellow-300 bg-[#fff333] shadow-sm overflow-hidden">
                        <marquee behavior="scroll" direction="left" scrollamount="10" class="block py-2 text-2xl font-semibold text-red-500">
                            {{ $marqueeText->text }}
                        </marquee>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===== CYCLE TIME ===== --}}
        @if ($selectedLineId)
            {{-- Minimal satu layar penuh (xl+): mode, baris chart + log, lalu trend mengisi sisa tinggi.
                 Trend punya tinggi minimum agar tetap terlihat di layar/jendela yang pendek. --}}
            <div class="pt-10">
                <div class="flex flex-col gap-4 xl:min-h-[calc(100vh-6.5rem)]">
                    <x-cycle-time.mode-panel class="shrink-0" :patterns="$patterns" :active-pattern="$activePattern" />

                    {{-- Tinggi baris mengikuti activity log (5 data); bar chart menyesuaikan --}}
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 shrink-0 mt-10">
                        <x-cycle-time.realtime-chart
                            fill
                            class="xl:col-span-2 min-h-[360px] xl:min-h-0"
                            :data="$realtimeData"
                            :active-pattern="$activePattern"
                        />
                        <x-cycle-time.activity-log
                            :logs="$recentActivity['logs']"
                            :total="$recentActivity['total']"
                        />
                    </div>

                    <x-cycle-time.trend-chart
                        fill
                        class="min-h-[320px] xl:flex-1"
                        :data="$trendData"
                        :pattern="$activePattern"
                    />
                </div>
            </div>
        @endif
    </div>
    <x-layout.footer />
</div>

<x-ui.scroll-control />
@endsection
