@extends('layouts.system-manager')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">
            {{-- HERO HEADER --}}
            <x-layout.page-hero title="LINE PERFORMANCE" image="assets/images/performance.jpg" alt="Line Performance">
                Track and manage monthly OEE performance data for the
                <span class="font-semibold text-red-600">AISS production line</span>.
                Monitor target vs actual metrics across all operational periods.
            </x-layout.page-hero>

            {{-- CREATE FORM --}}
            <x-form.pages.line-performance-create />

            {{-- TABLE DATA --}}
            <x-table.pages.line-performance :line-performances="$linePerformances" />
        </div>

        <x-layout.footer />
    </div>
@endsection
