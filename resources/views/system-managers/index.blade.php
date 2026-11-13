@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">
        <div class="flex flex-row mb-6">
            <div class="flex flex-col">
                <div class="flex flex-row">
                    <x-dashboard.best-record
                        :day-count="$best_record['day_count']"
                        :last-day="$best_record['last_day']"
                    />
                    {{-- ===== SECURITY MATRIX WIDGET ===== --}}
                    <div class="mb-6">
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
                </div>
                <!-- Line Performance -->
                <div class="mt-4 w-full flex flex-col">
                    <x-dashboard.line-performance
                        :items="$linePerformances"
                    />
                </div>
            </div>
            <div class="flex flex-col">
                
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
    <x-layout.footer />
</div>
@endsection
