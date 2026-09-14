@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Machine Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img
                    src="{{ $machine->image_path ? asset('storage/machines/images/' . $machine->image_path) : asset('assets/images/machine-1.jpg') }}"
                    alt="{{ $machine->asset_name }}"
                    class="w-full h-full object-cover">
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
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('machines.index') }}" class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Machine List
                    </a>
                    <span class="text-gray-300">/</span>
                    <span class="text-xs font-semibold text-sky-600">{{ $machine->asset_no }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $machine->asset_name }}</h1>
                <p class="mt-1 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    Edit machine information and manage linked SOP documents.
                </p>
            </div>
        </div>

        {{-- ===== MACHINE ADD ===== --}}
        <div class="mb-6">
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Machine Details</p>
                <h2 class="text-xl font-bold text-gray-900">Edit Machine Information</h2>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <form action="{{ route('machines.update', $machine->asset_no) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        {{-- Asset No (readonly) --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Asset No.</label>
                            <div class="w-full border border-gray-100 rounded-lg px-3 py-2.5 text-sm text-gray-400 bg-gray-50 font-mono">
                                {{ $machine->asset_no }}
                            </div>
                        </div>
                        {{-- Asset Name --}}
                        <div>
                            <label for="asset_name" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Asset Name</label>
                            <input
                                type="text"
                                name="asset_name"
                                id="asset_name"
                                value="{{ old('asset_name', $machine->asset_name) }}"
                                required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 placeholder:text-gray-400 placeholder:italic focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Acquisition Date --}}
                        <div>
                            <label for="acquisition_date" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Acquisition Date</label>
                            <input
                                type="date"
                                name="acquisition_date"
                                id="acquisition_date"
                                value="{{ old('acquisition_date', optional($machine->acquisition_date)->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 placeholder:text-gray-400 placeholder:italic focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Manufacturer --}}
                        <div>
                            <label for="manufacturer" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Manufacturer</label>
                            <input
                                type="text"
                                name="manufacturer"
                                id="manufacturer"
                                value="{{ old('manufacturer', $machine->manufacturer) }}"
                                placeholder="empty"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 placeholder:text-gray-400 placeholder:italic focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Model --}}
                        <div>
                            <label for="model" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Model</label>
                            <input
                                type="text"
                                name="model"
                                id="model"
                                value="{{ old('model', $machine->model) }}"
                                placeholder="empty"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 placeholder:text-gray-400 placeholder:italic focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Image --}}
                        <div>
                            <label for="image-path" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Image</label>
                            <div class="flex items-center gap-3 border border-gray-200 rounded-lg px-1.5 py-1.5 bg-gray-50 hover:border-gray-300 transition">
                                <button
                                    type="button"
                                    id="button-image-path"
                                    class="shrink-0 px-4 py-1.5 bg-white border border-gray-200 text-gray-700 font-semibold text-xs rounded-lg transition whitespace-nowrap shadow-sm"
                                >
                                    Browse File
                                </button>
                                <span id="span-image-path" class="text-sm text-gray-500 flex-1 truncate">{{ $machine->image_path ?? 'No file selected' }}</span>
                                <input
                                    type="file"
                                    name="image_path"
                                    id="image-path"
                                    accept="image/*"
                                    class="hidden">
                            </div>
                        </div>
                    </div>
                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="flex justify-end">
                        <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-sky-500 to-sky-600 hover:brightness-110 text-white font-bold text-sm px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200 whitespace-nowrap uppercase">
                            Save
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== SOP LINKED TABLE ===== --}}
        <div class="mb-6">
            <div class="flex items-end justify-between mb-3">
                {{-- Title --}}
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Documents</p>
                    <h2 class="text-xl font-bold text-gray-900">Linked SOP Documents</h2>
                </div>
            </div>

            {{-- SOP Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Search bar + Add SOP --}}
                <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form id="sop-search-form" method="GET" class="flex items-center gap-2 flex-1 max-w-lg">
                        {{-- Search Input --}}
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search" id="sop-search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search SOP name, SOP number..."
                                   class="placeholder:text-gray-400 block w-full pl-9 pr-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"/>
                        </div>
                        {{-- Button Search --}}
                        <button type="submit"
                                class="px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">
                            Search
                        </button>
                        {{-- Button Reset --}}
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition shrink-0 uppercase">
                                Reset
                            </a>
                        @endif
                    </form>

                    {{-- Add SOP Button --}}
                    @if($availableSops->count() > 0)
                        <button
                            type="button"
                            data-modal-open="add-sop-modal"
                            class="flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:brightness-110 text-white font-bold text-sm mr-1 px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200 whitespace-nowrap uppercase"
                        >
                            <span class="uppercase">Add</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    @else
                        <span class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-bold text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed shrink-0">
                            All Linked
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                    @endif
                </div>

                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-150 text-center text-gray-500 font-bold text-[10px] tracking-widest uppercase">
                            <th class="px-5 py-3">SOP Name</th>
                            <th class="px-5 py-3">SOP No.</th>
                            <th class="px-5 py-3">Link</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($machine->sops as $sop)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                                {{-- SOP Name --}}
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-sm text-slate-700">{{ $sop->name }}</div>
                                </td>
                                {{-- SOP No --}}
                                <td class="px-5 py-4 text-center">
                                    <span class="font-mono text-sm text-slate-500">
                                        {{ $sop->sop_no ?? '-' }}
                                    </span>
                                </td>
                                {{-- Link --}}
                                <td class="px-5 py-4 text-center">
                                    @if($sop->link)
                                        <a href="{{ asset('storage/' . $sop->link) }}" target="_blank"
                                           class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 hover:text-sky-800 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                            Open
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                        {{-- Unlink SOP --}}
                                        <form
                                            action="{{ route('machines.sop.detach', ['id' => $machine->asset_no, 'sopId' => $sop->id]) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Remove this SOP from the machine?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                title="Unlink SOP"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 transition shadow-sm"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-400 text-sm">No SOP documents linked yet.</p>
                                        <p class="text-gray-300 text-xs mt-1">Click <span class="font-semibold text-emerald-500">Add SOP</span> to link a document.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- SOP Count Footer --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                    <p class="text-xs text-slate-400 font-medium">
                        {{ $machine->sops->count() }} SOP{{ $machine->sops->count() !== 1 ? 's' : '' }} linked to this machine
                    </p>
                </div>
            </div>
        </div>

    </div>
    <x-ui.footer />
</div>

{{-- ===== ADD SOP MODAL ===== --}}
<x-ui.modal id="add-sop-modal">
    <div class="w-full bg-white rounded-2xl shadow-xl border border-gray-100 flex flex-col" style="width: 480px; max-width: 95vw; max-height: 90vh;">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 shrink-0">
            <div>
                <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-0.5">Documents</p>
                <h3 class="text-base font-bold text-gray-900 leading-tight">Link SOP to Machine</h3>
            </div>
            <button type="button" data-modal-close="add-sop-modal"
                class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        {{-- Form --}}
        <form action="{{ route('machines.sop.attach', $machine->asset_no) }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            {{-- Modal Body (scrollable) --}}
            <div class="px-6 py-5 space-y-5 overflow-y-auto flex-1">

                {{-- Machine context --}}
                <div class="flex items-center justify-between py-3 px-4 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-0.5">Machine</p>
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $machine->asset_name }}</p>
                    </div>
                    <span class="text-xs font-mono font-semibold text-gray-400 shrink-0 ml-3">{{ $machine->asset_no }}</span>
                </div>

                {{-- Select SOP — pakai komponen reusable --}}
                <div>
                    <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">Select SOP Document</label>

                    <x-ui.searchable-dropdown
                        id="sop"
                        name="sop_id"
                        placeholder="Select SOP Document"
                        search-placeholder="Search SOP..."
                        :required="true"
                    >
                        @forelse($availableSops as $sop)
                            <li>
                                <a
                                    href="#"
                                    class="dropdown-option flex flex-col px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-100 transition"
                                    data-id="{{ $sop->id }}"
                                    data-value="{{ $sop->name }}{{ $sop->sop_no ? ' (' . $sop->sop_no . ')' : '' }} — Rev {{ $sop->revision }}"
                                >
                                    <span class="font-semibold text-gray-800 text-sm">{{ $sop->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $sop->sop_no ?? '-' }} — Rev {{ $sop->revision }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="px-3 py-4 text-center text-sm text-gray-400">No SOP available</li>
                        @endforelse
                    </x-ui.searchable-dropdown>

                    <p class="text-xs text-gray-400 mt-2">Only SOPs not yet linked to this machine are shown.</p>
                </div>
            </div>{{-- end scrollable body --}}

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-100 shrink-0">
                <button type="button" data-modal-close="add-sop-modal"
                    class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 rounded-lg transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-lg transition">
                    Link SOP
                </button>
            </div>
        </form>
    </div>
</x-ui.modal>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const buttonImagePath = document.getElementById('button-image-path');
        const inputImagePath  = document.getElementById('image-path');
        const spanImagePath   = document.getElementById('span-image-path');

        if (buttonImagePath && inputImagePath) {
            buttonImagePath.addEventListener('click', () => inputImagePath.click());
            inputImagePath.addEventListener('change', () => {
                spanImagePath.textContent = inputImagePath.files.length > 0 ? inputImagePath.files[0].name : 'No file selected';
            });
        }
    });

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
</script>
@endsection
