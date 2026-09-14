@extends('layouts.machine-detail')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-8">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-sm font-bold tracking-widest uppercase text-red-600">
                        Machine Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row gap-8">
                        {{-- Photo --}}
                        <div class="w-full lg:w-72 shrink-0">
                            <div class="rounded-xl overflow-hidden border border-gray-200 h-48">
                                <img
                                    src="{{ $machine->image_path ? asset('storage/machines/images/' . $machine->image_path) : asset('assets/images/machine-1.jpg') }}"
                                    alt="{{ $machine->asset_name }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                        {{-- Information --}}
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 uppercase">
                                {{ $machine->asset_name }}
                            </h1>
                            <p class="text-gray-500 mt-1">
                                Asset No :
                                <span class="font-mono font-semibold">
                                    {{ $machine->asset_no }}
                                </span>
                            </p>
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-5 mt-8">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Manufacturer</p>
                                    <p class="font-semibold">{{ $machine->manufacturer ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Model</p>
                                    <p class="font-semibold">{{ $machine->model ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Line</p>
                                    <p class="font-semibold">{{ $machine->line->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Acquisition</p>
                                    <p class="font-semibold">{{ $machine->acquisition_date?->format('d-m-Y') ?? '-' }} </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Status</p>
                                    @if($machine['status']=='Running')
                                        <span class="inline-flex items-center gap-2 text-green-600 font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            Running
                                        </span>
                                    @elseif($machine['status']=='Idle')
                                        <span class="inline-flex items-center gap-2 text-yellow-600 font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                            Idle
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 text-red-600 font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                            Maintenance
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden flex flex-col" id="right-panel" style="height: var(--left-h, auto)">
                {{-- Panel header --}}
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-600"></span>
                        <h3 class="text-sm font-bold tracking-widest text-red-600 uppercase">Document Connections</h3>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                        {{ $sops->count() }} SOP
                    </span>
                </div>
                <div class="overflow-auto border border-gray-200 shadow-sm">
                    <table class="w-full table-fixed border-collapse text-sm">
                        {{-- Tentukan lebar setiap kolom --}}
                        <colgroup>
                            <col class="w-60">
                            <col class="w-60">
                            @foreach($allDasgs as $dasg)
                                <col class="w-40">
                            @endforeach
                        </colgroup>
                        <thead>
                            <tr>
                                {{-- SOP --}}
                                <th rowspan="2" class="sticky top-0 left-0 z-40 bg-gray-50 border-b border-r border-gray-200 px-4 py-3 text-center font-semibold text-gray-700 tracking-wide">
                                    SOP
                                </th>
                                {{-- Risk Assessment --}}
                                <th rowspan="2"
                                    class="sticky top-0 left-60 z-40 bg-gray-50 border-b border-r border-gray-200 px-4 py-3 text-center font-semibold text-gray-700 tracking-wide">
                                    Risk Assessment
                                </th>
                                {{-- DASG --}}
                                <th colspan="{{ max($allDasgs->count(), 1) }}"
                                    class="sticky top-0 z-30 bg-gray-50 border-b border-gray-200 py-3 font-semibold text-center text-gray-700 tracking-wide">
                                    DASG
                                </th>
                            </tr>
                            <tr>
                                @forelse($allDasgs as $dasg)
                                    <th class="sticky top-[45px] z-30 bg-gray-50/95 border-b border-l border-gray-200 px-3 py-2 text-center text-xs font-medium text-gray-500 leading-snug">
                                        @if($dasg->link)
                                            <a href="{{ Storage::url($dasg->link) }}" target="_blank" class="text-slate-500 hover:text-blue-700 hover:underline">
                                                {{ $dasg->name }}
                                            </a>
                                        @else
                                            {{ $dasg->name }}
                                        @endif
                                    </th>
                                @empty
                                    <th class="sticky top-[45px] z-30 bg-gray-50/95 border-b border-l border-gray-200"></th>
                                @endforelse
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($sops as $sop)
                                <tr class="group hover:bg-gray-50/70 transition-colors">
                                    {{-- SOP --}}
                                    <td class="sticky left-0 z-20 bg-white group-hover:bg-gray-50/70 border-r border-gray-200 px-4 py-3">
                                        @if($sop->link)
                                            <a
                                                href="{{ Storage::url($sop->link) }}"
                                                target="_blank"
                                                class="text-slate-600 hover:text-blue-700 hover:underline font-medium"
                                            >
                                                {{ $sop->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-700">{{ $sop->name }}</span>
                                        @endif
                                    </td>
                                    {{-- Risk Assessment --}}
                                    <td class="sticky left-60 z-20 bg-white text-center group-hover:bg-gray-50/70 border-r border-gray-200 px-4 py-3">
                                        @if($sop->riskAssessment)
                                            @if($sop->riskAssessment->link)
                                                <a
                                                    href="{{ Storage::url($sop->riskAssessment->link) }}"
                                                    target="_blank"
                                                    class="text-slate-500 hover:text-blue-700 hover:underline"
                                                >
                                                    {{ $sop->riskAssessment->ra_no }}
                                                </a>
                                            @else
                                                <span class="text-gray-700">{{ $sop->riskAssessment->name }}</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    {{-- DASG --}}
                                    @foreach($allDasgs as $dasg)
                                        <td class="border-l border-gray-100 text-center h-12">
                                            @if($sop->dasgs->contains('id', $dasg->id))
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                <span class="text-gray-300 text-xs">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ max($allDasgs->count(), 1) + 2 }}" class="py-16">
                                        <div class="flex flex-col items-center justify-center gap-3 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2m9 10V7" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-500">Belum ada koneksi dokumen</p>
                                            <p class="text-xs text-gray-400">Data SOP, Risk Assessment, dan DASG akan tampil di sini setelah ditautkan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="xl:px-32">
        <x-ui.footer />
    </div>
</div>
<script>
    function syncPanelHeight() {

        const left  = document.getElementById('left-panel');
        const right = document.getElementById('right-panel');

        if (!left || !right) return;

        right.style.height = left.offsetHeight + 'px';
    }

    // Run after layout is painted
    document.addEventListener('DOMContentLoaded', syncPanelHeight);
    window.addEventListener('resize', syncPanelHeight);
</script>
@endsection
