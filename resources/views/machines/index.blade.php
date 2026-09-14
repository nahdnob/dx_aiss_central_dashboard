@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Machine Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/machine-1.jpg') }}" alt="Machine Management" class="w-full h-full object-cover">
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
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight uppercase">Machine Management</h1>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    Real-time status monitoring of workstations and documents on the
                    <span class="font-semibold text-red-600">AISS production line</span>.
                    Track asset numbers, acquisition dates, and documentation completeness.
                </p>
            </div>
        </div>

        {{-- ===== FORM OPERATIONS INPUT ===== --}}
        <div class="mb-6">
            {{-- Title --}}
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Operations Input</p>
                <h2 class="text-xl font-bold text-gray-900">Add New Machine</h2>
            </div>
            {{-- Form --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <form action="{{ route('machines.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3 items-end">
                        {{-- Asset No --}}
                        <div class="flex-1 min-w-0">
                            <label for="asset_no" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Asset No.</label>
                            <input class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="text"
                                name        ="asset_no"
                                id          ="asset_no"
                                value       ="{{ old('asset_no') }}"
                                placeholder ="e.g., Asset-123..."
                                required>
                        </div>
                        {{-- Asset Name --}}
                        <div class="flex-1 min-w-0">
                            <label for="asset_name" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Asset Name</label>
                            <input class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="text"
                                name        ="asset_name"
                                id          ="asset_name"
                                value       ="{{ old('asset_name') }}"
                                placeholder ="e.g., Machine..."
                                required>
                        </div>
                        {{-- Acquisition Date --}}
                        <div class="flex-1 min-w-0">
                            <label for="acq_date" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Acq Date</label>
                            <input class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type  ="date"
                                name  ="acquisition_date"
                                id    ="acquisition_date"
                                value ="{{ old('acquisition_date') }}"
                                required>
                        </div>
                        <div class="flex-1 min-w-0 w-full">
                            <label for="image" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Images</label>
                            <div class="flex items-center gap-3 border border-gray-200 rounded-lg px-1.5 py-1.5 bg-gray-50 hover:border-gray-300 transition">
                                <button type="button" id="button-image-path" class="shrink-0 px-4 py-1.5 bg-white border border-gray-200 text-gray-700 font-semibold text-xs rounded-lg transition whitespace-nowrap shadow-sm">Browse File</button>
                                <span id="span-image-path" class="text-sm text-gray-500 flex-1 truncate">No image selected</span>
                                <input class="hidden"
                                    type   ="file"
                                    name   ="image_path"
                                    id     ="image-path"
                                    accept ="image/*">
                            </div>
                        </div>
                        <div class="shrink-0 w-full sm:w-auto">
                            <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:brightness-110 text-white font-bold text-sm px-5 py-2.5 rounded-lg shadow-sm shadow-red-200 transition-all duration-200 whitespace-nowrap uppercase">
                                Add
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== TABLE MACHINE DATA ===== --}}
        <div class="mb-6">
            <div class="flex items-end justify-between mb-3">
                {{-- Title and Description --}}
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Machine Data</p>
                    <h2 class="text-xl font-bold text-gray-900">Workstation Status</h2>
                </div>
                <!-- <div class="flex items-center gap-2">
                    {{-- Button Filter --}}
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M7 10h10M11 16h2"/>
                        </svg>
                    </button>
                    {{-- Button Export --}}
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                        </svg>
                    </button>
                </div> -->
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Search bar --}}
                <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form id="machine-search-form" method="GET" action="{{ route('machines.index') }}" class="flex items-center gap-2 flex-1 max-w-lg">
                        {{-- Input Search --}}
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input class="placeholder:text-gray-400 block w-full pl-9 pr-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="search"
                                id          ="search"
                                name        ="search"
                                value       ="{{ request('search') }}"
                                placeholder ="Search asset number, asset name...">
                        </div>
                        {{-- Button Search --}}
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">Search</button>
                        {{-- Button Reset --}}
                        @if(request('search'))
                            <a href="{{ route('machines.index') }}" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition shrink-0 uppercase">Reset</a>
                        @endif
                    </form>
                </div>
                {{-- Table --}}
                <table class="w-full text-sm text-left">
                    {{-- Table Header --}}
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-150 text-center text-gray-500 font-bold text-[10px] tracking-widest uppercase">
                            <th class="px-5 py-3">Asset No.</th>
                            <th class="px-5 py-3">Asset Name</th>
                            <th class="px-5 py-3">Acq Date</th>
                            <th class="px-5 py-3">Sop Linked</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($machines as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                                {{-- Asset No --}}
                                <td class="px-5 py-4 text-center">
                                    <div class="font-mono text-sm text-slate-500">
                                        {{ $item->asset_no }}
                                    </div>
                                </td>
                                {{-- Asset Name --}}
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-gray-900 text-sm">{{ $item->asset_name }}</div>
                                </td>
                                {{-- Acq Date --}}
                                <td class="px-5 py-4 text-center">
                                    <span class="font-normal text-gray-600 font-mono">
                                        {{ $item->acquisition_date->format('Y-m-d') ?? '-' }}
                                    </span>
                                </td>
                                {{-- SOP Linked --}}
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-bold bg-slate-400 text-white">
                                        {{ $item->sops_count ?? 0 }}
                                    </span>
                                </td>
                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                        {{-- Open + Edit Group --}}
                                        <div class="inline-flex items-center rounded-full bg-gradient-to-r from-sky-500 to-sky-600 overflow-hidden shadow-sm">
                                            {{-- Open --}}
                                            <a
                                                href="{{ route('machines.show', ['id' => $item->asset_no]) }}"
                                                target="_blank"
                                                title="Open"
                                                class="w-10 h-8 flex items-center justify-center text-white hover:bg-white/10 transition"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                            </a>
                                            {{-- Divider --}}
                                            <div class="w-px h-5 bg-blue-300"></div>
                                            {{-- Edit --}}
                                            <a
                                                href="{{ route('machines.edit', ['id' => $item->asset_no]) }}"
                                                title="Edit & Link SOP"
                                                class="w-10 h-8 flex items-center justify-center text-white hover:bg-white/10 transition"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('machines.destroy', ['id' => $item->asset_no]) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this machine?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                title="Delete"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 transition shadow-sm"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- Empty State --}}
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-gray-400 text-sm">Nothing machines data yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Footer Pagination --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                    <p class="text-xs text-slate-400 font-medium">
                        Showing {{ $machines->firstItem() ?? 0 }}–{{ $machines->lastItem() ?? 0 }} of {{ $machines->total() }} machine{{ $machines->total() !== 1 ? 's' : '' }}
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($machines->onFirstPage())
                            <span class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $machines->previousPageUrl() }}"
                            class="px-4 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Previous
                            </a>
                        @endif
                        @if ($machines->hasMorePages())
                            <a href="{{ $machines->nextPageUrl() }}"
                            class="px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg hover:brightness-110 shadow-sm shadow-red-200 transition">
                                Next
                            </a>
                        @else
                            <span class="px-4 py-1.5 text-xs font-bold text-white bg-sky-300 rounded-lg cursor-not-allowed">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-ui.footer />
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ADD FORM — File input
    const buttonImagePath = document.getElementById('button-image-path');
    const inputImagePath  = document.getElementById('image-path');
    const spanImagePath   = document.getElementById('span-image-path');

    if (buttonImagePath && inputImagePath) {
        buttonImagePath.addEventListener('click', () => inputImagePath.click());
        inputImagePath.addEventListener('change', () => {
            spanImagePath.textContent = inputImagePath.files.length > 0 ? inputImagePath.files[0].name : 'No file selected';
        });
    }

    // EDIT MODALS — File picker
    document.querySelectorAll('.edit-file-btn').forEach(btn => {
        const wrapper   = btn.closest('.flex.items-center.gap-3');
        const fileInput = wrapper.querySelector('.edit-file-input');
        const label     = wrapper.querySelector('.edit-file-name');

        btn.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => {
            label.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : label.textContent;
        });
    });
});
</script>
@endsection
