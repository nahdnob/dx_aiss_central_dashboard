@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Hero Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/trophy.jpg') }}" alt="System Manager" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
            </div>
            {{-- Decorative Right Background --}}
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-red-50 to-transparent z-20"></div>
            {{-- Decorative Glow Circle --}}
            <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-red-500/10 blur-3xl z-30"></div>
            {{-- Decorative Small Circle --}}
            <div class="absolute right-20 top-1/2 -translate-y-1/2 w-24 h-24 rounded-full bg-red-100/50 z-30"></div>
            {{-- Content --}}
            <div class="relative z-40 px-8 py-5 pl-[380px] min-h-[140px] flex flex-col justify-center">
                <div class="flex items-start justify-between flex-wrap gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">SYSTEM MANAGER</h1>
                        <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                            Central control panel for managing the
                            <span class="font-semibold text-red-600">AISS Dashboard</span> system.
                            Configure users, modules, and system-wide settings from one place.
                        </p>
                    </div>
                    {{-- Active Line Badge + Change Button --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-50 border border-red-200">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="text-xs font-semibold text-red-700 uppercase tracking-wide">
                                {{ session('selected_line_name', 'No Line') }}
                            </span>
                        </div>
                        <form action="{{ route('line-selector.clear') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium text-gray-600 border border-gray-200 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                                Ganti Line
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== QUICK NAV CARDS ===== --}}
        <div class="mb-6">
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Navigation</p>
                <h2 class="text-xl font-bold text-gray-900">Quick Access</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Cycle Time Monitoring --}}
                <a href="{{ route('cycletimes.monitoring.index') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-red-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-red-50 group-hover:bg-red-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center shrink-0 group-hover:bg-red-200 transition-colors">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Monitoring</p>
                            <p class="text-base font-bold text-gray-900">Cycle Time</p>
                            <p class="text-xs text-gray-500 mt-0.5">Real-time sensor data</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                {{-- Cycle Time Settings --}}
                <a href="{{ route('cycletimes.setting.index') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-sky-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-sky-50 group-hover:bg-sky-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center shrink-0 group-hover:bg-sky-200 transition-colors">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Configuration</p>
                            <p class="text-base font-bold text-gray-900">Cycle Time Settings</p>
                            <p class="text-xs text-gray-500 mt-0.5">Patterns & thresholds</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                {{-- Line Performance --}}
                <a href="{{ route('line-performance.index') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-emerald-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-emerald-50 group-hover:bg-emerald-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition-colors">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">OEE</p>
                            <p class="text-base font-bold text-gray-900">Line Performance</p>
                            <p class="text-xs text-gray-500 mt-0.5">Monthly target vs actual</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                {{-- Best Records --}}
                <a href="{{ route('best-records.index') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-amber-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-amber-50 group-hover:bg-amber-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center shrink-0 group-hover:bg-amber-200 transition-colors">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Audit Log</p>
                            <p class="text-base font-bold text-gray-900">Best Records</p>
                            <p class="text-xs text-gray-500 mt-0.5">Claim history & actions</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                {{-- Machine Management --}}
                <a href="{{ route('machines.index') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-violet-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-violet-50 group-hover:bg-violet-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center shrink-0 group-hover:bg-violet-200 transition-colors">
                            <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Assets</p>
                            <p class="text-base font-bold text-gray-900">Machine Management</p>
                            <p class="text-xs text-gray-500 mt-0.5">Workstation status & docs</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                {{-- Production --}}
                <a href="{{ route('products.index') }}"
                   class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm p-5 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-teal-200">
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-teal-50 group-hover:bg-teal-100 transition-colors"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 flex items-center justify-center shrink-0 group-hover:bg-teal-200 transition-colors">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Tracking</p>
                            <p class="text-base font-bold text-gray-900">Production</p>
                            <p class="text-xs text-gray-500 mt-0.5">Part numbers & qty flow</p>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        {{-- ===== SECURITY MATRIX WIDGET ===== --}}
        <div class="mb-6">
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Statistics</p>
                <h2 class="text-xl font-bold text-gray-900">Security Rank & RA Level Matrix</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <!-- Machine Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5 flex flex-col items-center justify-center shadow-sm hover:shadow-md transition-shadow hover:border-emerald-300">
                    <span class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">MACHINE</span>
                    <span class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $machineCount }}</span>
                </div>
                <!-- SOP / RA Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5 flex flex-col items-center justify-center shadow-sm hover:shadow-md transition-shadow hover:border-orange-300">
                    <span class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">SOP / RA</span>
                    <span class="text-3xl font-extrabold text-orange-600 mt-2">{{ $totalSops }}/{{ $sopsWithRa }}</span>
                </div>
            </div>

            <!-- Matrix Table -->
            <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm max-w-full bg-white">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-[#1e6080] text-white text-center font-bold text-xs tracking-wider uppercase">
                            <th class="p-4 text-left border-r border-[#15465e] font-extrabold">Degree of security rank/RA Level</th>
                            <th class="p-4 border-r border-[#15465e] w-20">I</th>
                            <th class="p-4 border-r border-[#15465e] w-20">II</th>
                            <th class="p-4 border-r border-[#15465e] w-20">III</th>
                            <th class="p-4 border-r border-[#15465e] w-20">IV</th>
                            <th class="p-4 w-40">SOP without RA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-center font-semibold">
                        <!-- Row A -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-left font-bold text-gray-800 border-r border-gray-200 pl-6">A</td>
                            <td class="p-4 border-r border-gray-200 font-mono text-gray-500">{{ $matrix['A'][1] > 0 ? $matrix['A'][1] : '-' }}</td>
                            <td class="p-4 border-r border-gray-200 font-mono text-gray-500">{{ $matrix['A'][2] > 0 ? $matrix['A'][2] : '-' }}</td>
							<td class="p-4 border-r border-gray-200 font-mono text-gray-500">{{ $matrix['A'][3] > 0 ? $matrix['A'][3] : '-' }}</td>
                            <td class="p-4 border-r border-gray-200 font-mono text-gray-500">{{ $matrix['A'][4] > 0 ? $matrix['A'][4] : '-' }}</td>
                            <td class="p-4 bg-gray-100/80"></td>
                        </tr>
                        <!-- Row C -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-left font-bold text-gray-800 border-r border-gray-200 pl-6">(C)</td>
                            <td class="p-4 border-r border-gray-200 font-mono font-bold text-sky-800 text-base">{{ $matrix['C'][1] > 0 ? $matrix['C'][1] : '-' }}</td>
                            <td class="p-4 border-r border-gray-200 font-mono font-bold text-sky-800 text-base">{{ $matrix['C'][2] > 0 ? $matrix['C'][2] : '-' }}</td>
                            <td class="p-4 border-r border-gray-200 font-mono font-bold text-sky-800 text-base">{{ $matrix['C'][3] > 0 ? $matrix['C'][3] : '-' }}</td>
                            <td class="p-4 border-r border-gray-200 font-mono font-bold text-sky-800 text-base">{{ $matrix['C'][4] > 0 ? $matrix['C'][4] : '-' }}</td>
                            <td class="p-4 bg-gray-100/80"></td>
                        </tr>
                        <!-- Row E -->
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-left font-bold text-gray-800 border-r border-gray-200 pl-6">E</td>
                            <td class="p-4 bg-gray-100/80 border-r border-gray-200"></td>
                            <td class="p-4 bg-gray-100/80 border-r border-gray-200"></td>
                            <td class="p-4 bg-gray-100/80 border-r border-gray-200"></td>
                            <td class="p-4 bg-gray-100/80 border-r border-gray-200"></td>
                            <td class="p-4 font-mono font-bold text-rose-700 text-base bg-gray-100 border-l border-gray-200">{{ $matrix['E']['no_ra'] > 0 ? $matrix['E']['no_ra'] : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== INFO PANEL ===== --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold tracking-widest text-red-600 uppercase">System Info</p>
                    <h2 class="text-base font-bold text-gray-900">About AISS Central Dashboard</h2>
                </div>
            </div>
            <p class="text-sm text-gray-500 leading-relaxed max-w-3xl">
                AISS Central Dashboard is an integrated monitoring and management platform for the AISS production line.
                It provides real-time insights into cycle times, OEE performance, claim history, machine asset status, and part tracking —
                all accessible from a single, unified interface.
            </p>
        </div>

    </div>
    <x-ui.footer />
</div>
@endsection
