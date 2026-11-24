@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- HERO HEADER --}}
        <x-jumbotron title="PRODUCTION" image="assets/images/production.jpg" alt="Production">
            This is the real-time monitoring of product flow on the
            <span class="font-semibold text-red-600">AISS production line</span>.
            Track part numbers, quantities, and timestamps across all input/output points.
        </x-jumbotron>

        {{-- SUMMARY CARDS --}}
        <x-utility.auto-refresh :url="route('products.stats')" :interval="5000" class="block mb-6">
            @include('products.partials.stats')
        </x-utility.auto-refresh>

        {{-- PRODUCTION SUMMARY --}}
        <x-utility.auto-refresh :url="route('products.summary')" :interval="5000">
            @include('products.partials.summary')
        </x-utility.auto-refresh>

        {{-- PRODUCTION LOG --}}
        <x-utility.auto-refresh :url="route('products.log')" :interval="5000">
            @include('products.partials.log')
        </x-utility.auto-refresh>
    </div>

    {{-- Footer --}}
    <x-footer />
</div>
@endsection

@pushOnce('scripts')
    @vite('resources/js/entries/autoRefresh.js')
@endPushOnce
