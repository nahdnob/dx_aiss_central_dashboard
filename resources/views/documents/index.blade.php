@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">
        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Hero Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/trophy.jpg') }}" alt="Documents" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
            </div>
            {{-- Decorative Right Background --}}
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-blue-50 to-transparent z-20"></div>
            {{-- Decorative Glow Circle --}}
            <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-blue-500/10 blur-3xl z-30"></div>
            {{-- Decorative Small Circle --}}
            <div class="absolute right-20 top-1/2 -translate-y-1/2 w-24 h-24 rounded-full bg-blue-100/50 z-30"></div>
            {{-- Content --}}
            <div class="relative z-40 px-8 py-5 pl-[380px] min-h-[140px] flex flex-col justify-center">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">DOCUMENTS</h1>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    Access important documentation including
                    <span class="font-semibold text-blue-600">DASg, SOP, and Risk Assessment</span>
                    documents for the AISS production system.
                </p>
            </div>
        </div>

        {{-- ===== QUICK ACCESS CARDS ===== --}}
        <div class="mb-6">
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-blue-600 uppercase">Navigation</p>
                <h2 class="text-xl font-bold text-gray-900">Quick Access</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- DASg --}}
                <a href="{{ route('documents.dasg') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-indigo-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-indigo-50 group-hover:bg-indigo-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center shrink-0 group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Process</p>
                            <p class="text-base font-bold text-gray-900">DASg</p>
                            <p class="text-xs text-gray-500 mt-0.5">Design & Structure Guide</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                {{-- SOP --}}
                <a href="{{ route('documents.sop') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-cyan-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-cyan-50 group-hover:bg-cyan-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center shrink-0 group-hover:bg-cyan-200 transition-colors">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7 20H5a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2h-5m0 0H9m0 0V9m0 11v-2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Procedures</p>
                            <p class="text-base font-bold text-gray-900">SOP</p>
                            <p class="text-xs text-gray-500 mt-0.5">Standard Operating Procedures</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                {{-- Risk Assessment --}}
                <a href="{{ route('documents.risk-assessment') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-rose-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-rose-50 group-hover:bg-rose-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center shrink-0 group-hover:bg-rose-200 transition-colors">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0v2m6-6v2m0 4v2m-12-6v2m0 4v2M7 7h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Analysis</p>
                            <p class="text-base font-bold text-gray-900">Risk Assessment</p>
                            <p class="text-xs text-gray-500 mt-0.5">Hazard & mitigation analysis</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <x-ui.footer />
</div>
@endsection
