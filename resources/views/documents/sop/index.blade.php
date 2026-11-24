@extends('layouts.dashboard')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">

            {{-- HERO HEADER --}}
            <x-jumbotron title="SOP - Standard Operating Procedures" image="assets/images/performance.jpg" alt="SOP">
                Manage SOP documents for the AISS production system.
                <span class="font-semibold text-red-600">Add new procedures, edit, and track revisions</span>.
            </x-jumbotron>

            {{-- FORM OPERATIONS INPUT --}}
            <x-form.pages.sop-create :risk-assessments="$riskAssessments" />

            {{-- TABLE SOP DATA --}}
            <x-table.pages.sop :sops="$sops" :risk-assessments="$riskAssessments" :dasgs="$dasgs" />
        </div>
        
        {{-- FOOTER --}}
        <x-footer />
    </div>
@endsection
