@extends('layouts.system-manager')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">
            {{-- ===== HERO HEADER ===== --}}
            <x-layout.page-hero title="BEST RECORDS" image="assets/images/trophy.jpg" alt="Best Record">
                This is the history of claims that have occurred on the
                <span class="font-semibold text-red-600">AISS production line</span>.
                Precision tracking ensures continuous improvement and technical accountability across all industrial operations.
            </x-layout.page-hero>
            {{-- ===== FORM OPERATIONS INPUT ===== --}}
            <x-form.pages.best-record-create />
            {{-- ===== TABLE BEST RECORDS DATA ===== --}}
            <x-table.pages.best-record :ncds="$ncds" />
        </div>
        {{-- ===== FOOTER ===== --}}
        <x-layout.footer />
    </div>
@endsection