@extends('layouts.dashboard')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">
            {{-- ===== HERO HEADER ===== --}}
            <x-jumbotron title="CYCLE TIME SETTINGS" image="assets/images/setting.jpg" alt="Cycle Time Settings">
                Configure operating modes and patterns for the
                <span class="font-semibold text-red-600">AISS cycle time</span> monitoring module.
            </x-jumbotron>
            {{-- ===== MAIN GRID ===== --}}
            <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
                {{-- Sensor Mapping (2/5 width) --}}
                @include('cycletimes.partials.sensor-map', ['class' => 'xl:col-span-2'])
                {{-- Table Pattern Data (3/5 width) --}}
                <x-table.pages.pattern class="xl:col-span-3" :patterns="$patterns" :sensors="$sensors" />
            </div>
        </div>
        {{-- ===== FOOTER ===== --}}
        <x-footer />
    </div>
@endsection
