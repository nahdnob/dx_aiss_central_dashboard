@extends('layouts.system-manager')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">
            {{-- ===== HERO HEADER ===== --}}
            <x-layout.page-hero title="Risk Assessment" image="assets/images/performance.jpg" alt="Risk Assessment">
                Manage Risk Assessment documents for the AISS production system.
                <span class="font-semibold text-red-600">Add hazard analysis, edit, and track revisions</span>.
            </x-layout.page-hero>
            {{-- ===== FORM OPERATIONS INPUT ===== --}}
            <x-form.pages.risk-assessment-create />
            {{-- ===== TABLE RISK ASSESSMENT DATA ===== --}}
            <x-table.pages.risk-assessment :risk-assessments="$riskAssessments" :lines="$lines" />
        </div>
        {{-- ===== FOOTER ===== --}}
        <x-layout.footer />
    </div>
@endsection
