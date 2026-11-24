@props(['dasgs', 'lines' => []])

<div class="mb-6">
    {{-- Title & Description --}}
    <div class="flex items-end justify-between">
        <x-typography.heading eyebrow="Data" title="DASg Documents" />
    </div>
    {{-- ===== TABLE DASG DATA ===== --}}
    <x-table :headers="['Name', 'Detail Standard', 'Rev', 'File', 'Actions']">
        {{-- Table Header --}}
        <x-slot:toolbar>
            <x-table.search :action="route('dasgs.index')" placeholder="Search name, detail standard..." />
        </x-slot:toolbar>
        {{-- Table Content --}}
        @forelse ($dasgs as $item)
            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                {{-- Name --}}
                <td class="px-5 py-4">
                    <div class="font-semibold text-gray-900 text-sm">{{ $item->name }}</div>
                </td>
                {{-- Detail Standard --}}
                <td class="px-5 py-4 text-gray-600">
                    {{ $item->detail_standard }}
                </td>
                {{-- Revision --}}
                <td class="px-5 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-bold bg-slate-400 text-white">
                        {{ $item->revision }}
                    </span>
                </td>
                {{-- File --}}
                <td class="px-5 py-4 text-center">
                    <x-table.file-link :path="$item->link" />
                </td>
                {{-- Actions --}}
                <td class="px-5 py-4">
                    <x-table.action-hover>
                        {{-- Button Edit --}}
                        <x-button-group variant="info" class="!rounded-full">
                            <button data-modal-open="edit-dasg-modal-{{ $item->id }}" type="button" title="Edit" class="!w-8">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </x-button-group>
                        {{-- Button Delete --}}
                        <form action="{{ route('dasgs.destroy', $item->id) }}" method="POST" aria-label="Delete DASg" onsubmit="return confirm('Are you sure you want to delete this document?')">
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
            <x-modal.pages.edit-dasg :item="$item" :lines="$lines" />
        @empty
            {{-- Table Empty --}}
            <x-table.empty :colspan="5" message="No DASg documents yet." />
        @endforelse
        {{-- Table Footer --}}
        <x-slot:footer>
            <x-pagination :paginator="$dasgs" label="document" variant="numbered" />
        </x-slot:footer>
    </x-table>
</div>
