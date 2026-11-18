@extends('layouts.system-manager')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">
            {{-- ===== HERO HEADER ===== --}}
            <x-layout.page-hero title="DOCUMENTS" image="assets/images/trophy.jpg" alt="Documents">
                Access important documentation including
                <span class="font-semibold text-red-600">DASg, SOP, and Risk Assessment</span>
                documents for the AISS production system.
            </x-layout.page-hero>
            {{-- ===== QUICK ACCESS CARDS ===== --}}
            <div class="mb-6">
                <x-layout.section-title eyebrow="Navigation" title="Quick Access" />
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- DASg --}}
                    <x-ui.link-card :href="route('dasgs.index')" color="indigo" eyebrow="Process" title="DASg" description="Design & Structure Guide">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </x-ui.link-card>
                    {{-- SOP --}}
                    <x-ui.link-card :href="route('sops.index')" color="cyan" eyebrow="Procedures" title="SOP" description="Standard Operating Procedures">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7 20H5a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2h-5m0 0H9m0 0V9m0 11v-2"/>
                        </svg>
                    </x-ui.link-card>
                    {{-- Risk Assessment --}}
                    <x-ui.link-card :href="route('risk-assessments.index')" color="rose" eyebrow="Analysis" title="Risk Assessment" description="Hazard & mitigation analysis">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0v2m6-6v2m0 4v2m-12-6v2m0 4v2M7 7h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                        </svg>
                    </x-ui.link-card>
                </div>
            </div>
        </div>
        {{-- ===== FOOTER ===== --}}
        <x-layout.footer />
    </div>
@endsection
