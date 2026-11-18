@props(['machine', 'availableSops'])

<div class="mb-6">
    <x-layout.section-title eyebrow="Documents" title="Linked SOP Documents" />

    <x-table :headers="['SOP Name', 'SOP No.', 'Link', 'Actions']">
        <x-slot:toolbar>
            <x-table.search
                :action="url()->current()"
                placeholder="Search SOP name, SOP number..." />

            @if ($availableSops->count() > 0)
                <x-ui.button type="button" variant="success" data-modal-open="add-sop-modal">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add
                </x-ui.button>
            @else
                <x-ui.button type="button" variant="secondary" disabled
                    class="cursor-not-allowed !text-gray-400 hover:!bg-gray-100">
                    All Linked
                </x-ui.button>
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
                    <x-ui.action-hover>
                        <form action="{{ route('machines.sop.detach', ['id' => $machine->asset_no, 'sopId' => $sop->id]) }}"
                            method="POST"
                            onsubmit="return confirm('Remove this SOP from the machine?')">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger" icon title="Unlink SOP">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </x-ui.button>
                        </form>
                    </x-ui.action-hover>
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
