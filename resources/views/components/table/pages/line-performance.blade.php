@props(['linePerformances'])

<div class="mb-6">
    {{-- Title & Description --}}
    <div class="flex items-end justify-between">
        <x-typography.heading eyebrow="Performance Log" title="Monthly Achievement" />
    </div>
    {{-- ===== TABLE ===== --}}
    <x-table :headers="['Period', 'Target (%)', 'Actual (%)', 'Achievement', 'Action']">
        {{-- Table Header --}}
        <x-slot:toolbar>
            <x-table.search :action="route('line-performance.index')" placeholder="Search month, year..." />
        </x-slot:toolbar>
        {{-- Table Content --}}
        @forelse ($linePerformances as $item)
            <tr class="hover:bg-gray-50/40 transition-colors duration-150 group text-center">
                <td class="px-5 py-4 whitespace-nowrap text-left">
                    <div class="font-semibold text-gray-800 text-sm">{{ $item->year }} - {{ $item->month }}</div>
                </td>
                <td class="px-5 py-4 text-gray-600 font-medium">
                    {{ number_format($item->target, 1) }}%
                </td>
                <td class="px-5 py-4 font-medium {{ $item->actual >= $item->target ? 'text-gray-600' : 'text-red-600' }}">
                    {{ number_format($item->actual, 1) }}%
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-center">
                        <img src="{{ $item->target > $item->actual ? asset('assets/images/emote-cry.png') : asset('assets/images/emote-smile.png') }}" alt="Emoticon" class="w-10 h-10 object-contain">
                    </div>
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                            <x-button type="button"
                                variant="info"
                                icon
                                data-modal-open="edit-line-performance-modal-{{ $item->id }}"
                                title="Edit"
                                aria-label="Edit line performance"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </x-button>

                            <form action="{{ route('line-performance.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-button
                                    type="submit"
                                    variant="danger"
                                    icon
                                    title="Delete"
                                    aria-label="Delete line performance"
                                    onclick="return confirm('Hapus data {{ $item->month }} {{ $item->year }}?')"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </x-button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            {{-- Modal Edit --}}
            <x-modal.pages.edit-line-performance :item="$item" />
        @empty
            {{-- Table Empty --}}
            <x-table.empty :colspan="4" message="No line performances found." />
        @endforelse
        {{-- Table Footer --}}
        <x-slot:footer>
            <x-pagination :paginator="$linePerformances" label="line-performances" variant="numbered" />
        </x-slot:footer>
    </x-table>
</div>
