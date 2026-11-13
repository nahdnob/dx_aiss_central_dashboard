@extends('layouts.system-manager')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">

            {{-- ===== HERO HEADER ===== --}}
            <x-layout.page-hero title="Machines Management">
                Status monitoring of machines on the
                <span class="font-semibold text-red-600">AISS production line</span>.
                Track asset numbers, acquisition dates, and documentation connections.
            </x-layout.page-hero>

            {{-- ===== FORM OPERATIONS INPUT ===== --}}
            <div class="mb-6">
                <x-layout.section-title eyebrow="Operations Input" title="Add New Machine" />
                <x-ui.card class="p-5">
                    <form action="{{ route('machines.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-3 items-end">
                            <x-form.input name="asset_no" label="Asset No." placeholder="e.g., Asset-123..." required />
                            <x-form.input name="asset_name" label="Asset Name" placeholder="e.g., Machine..." required />
                            <x-form.input name="acquisition_date" label="Acq Date" type="date" required />
                            <x-form.file-input name="image_path" />
                            <x-ui.button variant="success" type="submit" class="w-full sm:w-auto">
                                Add
                                <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                </svg>
                            </x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </div>

            {{-- ===== TABLE MACHINE DATA ===== --}}
            <div class="mb-6">
                <div class="flex items-end justify-between mb-3">
                    {{-- Title and Description --}}
                    <x-layout.section-title eyebrow="Machine Data" title="Machines Information" />
                    <div class="flex items-center gap-2">
                        {{-- Button Filter --}}
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M7 10h10M11 16h2"/>
                            </svg>
                        </button>
                        {{-- Button Export --}}
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-500 transition" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <x-table :headers="['Asset No.', 'Asset Name', 'Acq Date', 'Sop Linked', 'Actions']">
                    <x-slot:toolbar>
                        <x-table.search
                            :action="route('machines.index')"
                            placeholder="Search asset number, asset name..." />
                    </x-slot:toolbar>
                    @forelse ($machines as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                            <td class="px-5 py-4 text-center">
                                <div class="font-mono text-sm text-slate-500">{{ $item->asset_no }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-gray-900 text-sm">{{ $item->asset_name }}</div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="font-normal text-gray-600 font-mono">
                                    {{ $item->acquisition_date?->format('Y-m-d') ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-bold {{ $item->sops_count > 0 ? 'bg-emerald-400' : 'bg-slate-400' }} text-white">
                                    {{ $item->sops_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <x-ui.action-hover>
                                    <x-ui.button-group>
                                        <a href="{{ route('machines.show', ['id' => $item->asset_no]) }}" title="Open" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('machines.edit', ['id' => $item->asset_no]) }}" title="Edit & Link SOP">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </x-ui.button-group>
                                    {{-- Delete: group dengan 1 item, variant danger --}}
                                    <form action="{{ route('machines.destroy', ['id' => $item->asset_no]) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this machine?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button-group variant="danger" class="!rounded-full">
                                            <button type="submit" title="Delete" class="!w-8">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </x-ui.button-group>
                                    </form>
                                </x-ui.action-hover>
                            </td>
                        </tr>
                    @empty
                        <x-table.empty :colspan="5" message="Nothing machines data yet." />
                    @endforelse
                    <x-slot:footer>
                        <x-pagination :paginator="$machines" label="machine" variant="numbered" />
                    </x-slot:footer>
                </x-table>
            </div>
        </div>
        <x-layout.footer />
    </div>
@endsection