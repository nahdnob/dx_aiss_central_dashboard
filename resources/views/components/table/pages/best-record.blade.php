@props(['ncds'])

<div class="mb-6">
    {{-- Title & Description --}}
    <div class="flex items-end justify-between">
        <x-typography.heading eyebrow="Audit Log" title="Claim History" />
    </div>
    {{-- ===== TABLE BEST RECORDS DATA ===== --}}
    <x-table :headers="['Date', 'Claim', 'Action', 'Actions']">
        {{-- Table Header --}}
        <x-slot:toolbar>
            <x-table.search :action="route('best-records.index')" placeholder="Search claim or action..." />
        </x-slot:toolbar>
        {{-- Table Content --}}
        @forelse ($ncds as $item)
            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                {{-- Date --}}
                <td class="px-5 py-4 whitespace-nowrap">
                    <div class="font-semibold text-gray-800 text-sm">
                        {{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}
                    </div>
                </td>
                {{-- Claim --}}
                <td class="px-5 py-4 text-gray-600">
                    {{ $item->claim }}
                </td>
                {{-- Countermeasure --}}
                <td class="px-5 py-4 text-gray-600">
                    {{ $item->action }}
                </td>
                {{-- Actions --}}
                <td class="px-5 py-4">
                    <x-table.action-hover>
                        {{-- Button Edit --}}
                        <x-button-group variant="info" class="!rounded-full">
                            <button data-modal-open="edit-best-records-modal-{{ $item->id }}" type="submit" title="Edit" class="!w-8">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </x-button-group>
                        {{-- Button Delete --}}
                        <form action="{{ route('best-records.destroy', $item->id) }}" method="POST" title="Delete" aria-label="Delete claim" onclick="return confirm('Hapus record ini?')">
                            @csrf
                            @method('DELETE')
                            <x-button-group variant="danger" class="!rounded-full">
                                <button type="submit" title="Delete" class="!w-8">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </x-button-group>
                        </form>
                    </x-table.action-hover>
                </td>
            </tr>
            {{-- Modal Edit --}}
            <x-modal.pages.edit-best-record :item="$item" />
        @empty
            {{-- Table Empty --}}
            <x-table.empty :colspan="4" message="No best records found." />
        @endforelse
        {{-- Table Footer --}}
        <x-slot:footer>
            <x-pagination :paginator="$ncds" label="best-record" variant="numbered" />
        </x-slot:footer>
    </x-table>
</div>