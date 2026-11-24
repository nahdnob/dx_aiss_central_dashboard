@props(['machine', 'availableSops'])

<x-modal id="add-sop-modal">
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
                    <x-form.searchable-dropdown id="sop" name="sop_id"
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
                    </x-form.searchable-dropdown>
                    <p class="text-xs text-gray-400 mt-2">Only SOPs not yet linked to this machine are shown.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-100 shrink-0">
                <x-button type="button" variant="secondary" data-modal-close="add-sop-modal">Cancel</x-button>
                <x-button type="submit" variant="info">Link SOP</x-button>
            </div>
        </form>
    </div>
</x-modal>
