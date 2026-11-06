@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <x-ui.page-hero
            :title="$machine->asset_name"
            :image="$machine->image_path ? 'storage/machines/images/' . $machine->image_path : null"
            :breadcrumbs="[
                ['label' => 'Machine List', 'url' => route('machines.index')],
                ['label' => $machine->asset_no],
            ]">
            Edit machine information and manage linked SOP documents.
        </x-ui.page-hero>

        {{-- ===== FORM EDIT MACHINE ===== --}}
        <div class="mb-6">
            <x-section-title eyebrow="Machine Details" title="Edit Machine Information" />
            <x-card class="p-5">
                <form action="{{ route('machines.update', $machine->asset_no) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <x-input name="asset_no"
                                 label="Asset No."
                                 :value="$machine->asset_no"
                                 readonly
                                 class="!text-gray-400 !border-gray-100 font-mono cursor-not-allowed" />
                        <x-input name="asset_name"
                                 label="Asset Name"
                                 :value="$machine->asset_name"
                                 required />
                        <x-input name="acquisition_date"
                                 label="Acquisition Date"
                                 type="date"
                                 :value="$machine->acquisition_date?->format('Y-m-d')" />
                        <x-input name="manufacturer"
                                 label="Manufacturer"
                                 :value="$machine->manufacturer"
                                 placeholder="empty" />
                        <x-input name="model"
                                 label="Model"
                                 :value="$machine->model"
                                 placeholder="empty" />
                        <x-file-input name="image_path" :current="$machine->image_path" />
                    </div>
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="flex justify-end">
                        <x-button type="submit" variant="info">
                            Save
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        {{-- ===== SOP LINKED TABLE ===== --}}
        <div class="mb-6">
            <x-section-title eyebrow="Documents" title="Linked SOP Documents" />

            <x-table :headers="['SOP Name', 'SOP No.', 'Link', 'Actions']">
                <x-slot:toolbar>
                    <x-table.search
                        :action="url()->current()"
                        placeholder="Search SOP name, SOP number..." />

                    @if ($availableSops->count() > 0)
                        <x-button type="button" variant="success" data-modal-open="add-sop-modal">
                            Add
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </x-button>
                    @else
                        <x-button type="button" variant="secondary" disabled
                                  class="cursor-not-allowed !text-gray-400 hover:!bg-gray-100">
                            All Linked
                        </x-button>
                    @endif
                </x-slot:toolbar>

                @forelse ($machine->sops as $sop)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <td class="px-5 py-4">
                            <div class="font-semibold text-sm text-slate-700">{{ $sop->name }}</div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="font-mono text-sm text-slate-500">{{ $sop->sop_no ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if ($sop->link)
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
                        <td class="px-5 py-4">
                            <x-action-hover>
                                <form action="{{ route('machines.sop.detach', ['id' => $machine->asset_no, 'sopId' => $sop->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Remove this SOP from the machine?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" icon title="Unlink SOP">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                    </x-button>
                                </form>
                            </x-action-hover>
                        </td>
                    </tr>
                @empty
                    <x-table.empty :colspan="4" message="No SOP documents linked yet." />
                @endforelse

                <x-slot:footer>
                    <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                        <p class="text-xs text-slate-400 font-medium">
                            {{ $machine->sops->count() }} SOP{{ $machine->sops->count() !== 1 ? 's' : '' }} linked to this machine
                        </p>
                    </div>
                </x-slot:footer>
            </x-table>
        </div>
    </div>
    <x-ui.footer />
</div>

{{-- ===== ADD SOP MODAL ===== --}}
<x-ui.modal id="add-sop-modal">
    <div class="w-full bg-white rounded-2xl shadow-xl border border-gray-100 flex flex-col" style="width: 480px; max-width: 95vw; max-height: 90vh;">
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

        <form action="{{ route('machines.sop.attach', $machine->asset_no) }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <div class="px-6 py-5 space-y-5 overflow-y-auto flex-1">
                <div class="flex items-center justify-between py-3 px-4 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-0.5">Machine</p>
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $machine->asset_name }}</p>
                    </div>
                    <span class="text-xs font-mono font-semibold text-gray-400 shrink-0 ml-3">{{ $machine->asset_no }}</span>
                </div>

                <div>
                    <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">Select SOP Document</label>
                    <x-ui.searchable-dropdown id="sop" name="sop_id"
                        placeholder="Select SOP Document"
                        search-placeholder="Search SOP..."
                        :required="true">
                        @forelse ($availableSops as $sop)
                            <li>
                                <a href="#"
                                   class="dropdown-option flex flex-col px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-100 transition"
                                   data-id="{{ $sop->id }}"
                                   data-value="{{ $sop->name }}{{ $sop->sop_no ? ' (' . $sop->sop_no . ')' : '' }} — Rev {{ $sop->revision }}">
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
            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-100 shrink-0">
                <x-button type="button" variant="secondary" data-modal-close="add-sop-modal">Cancel</x-button>
                <x-button type="submit" variant="info">Link SOP</x-button>
            </div>
        </form>
    </div>
</x-ui.modal>
@endsection