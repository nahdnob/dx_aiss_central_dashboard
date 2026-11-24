@extends('layouts.dashboard')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">
            
            {{-- HERO HEADER --}}
            <x-jumbotron title="DASg" image="assets/images/performance.jpg" alt="DASg">
                Manage DASg documents for the AISS production system.
                <span class="font-semibold text-red-600">Add new standard details, edit, and track revisions</span>.
            </x-jumbotron>

            {{-- FORM OPERATIONS INPUT --}}
            <x-form.pages.dasg-create />

            {{-- TABLE DASG DATA --}}
            <x-table.pages.dasg :dasgs="$dasgs" :lines="$lines" />
        </div>

        {{-- FOOTER --}}
        <x-footer />
    </div>
@endsection
