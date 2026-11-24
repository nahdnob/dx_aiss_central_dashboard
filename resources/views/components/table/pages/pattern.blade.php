@props(['patterns', 'sensors'])

@php
    $headers = array_merge(
        ['Pattern'],
        $sensors->pluck('id')->map(fn ($id) => 'S' . $id)->all(),
        ['Cycle', 'Min – Max', 'Except', 'Actions'],
    );
@endphp

<div {{ $attributes->merge(['class' => 'mb-6 min-w-0']) }}>
    <x-typography.heading eyebrow="Configuration" title="Registered Patterns" />
    {{-- ===== TABLE PATTERN DATA ===== --}}
    <x-table :headers="$headers" dense>
        {{-- Table Header: search & add button --}}
        <x-slot:toolbar>
            <x-table.search :action="route('cycletimes.setting.index')" placeholder="Search pattern name..." />
            <x-button variant="success" data-modal-open="create-pattern-modal" class="shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add Pattern
            </x-button>
        </x-slot:toolbar>
        {{-- Table Content --}}
        @forelse ($patterns as $item)
            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                {{-- Pattern Name --}}
                <td class="px-3 py-3 whitespace-nowrap">
                    <div class="flex items-center gap-2 font-semibold text-gray-800 text-sm">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        {{ $item->name }}
                    </div>
                </td>
                {{-- Sensors: badge POS + jumlah barang per pembacaan --}}
                @foreach ($sensors as $sensor)
                    @php
                        $active = $item->sensors->firstWhere('id', $sensor->id);
                    @endphp
                    <td class="px-1.5 py-3 text-center whitespace-nowrap" title="{{ $sensor->name }}">
                        @if ($active)
                            <div class="flex flex-col items-center gap-0.5">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-sky-100 text-sky-600 font-bold text-xs" title="Pos {{ $active->pivot->pos }}">
                                    {{ $active->pivot->pos }}
                                </span>
                                <span @class([
                                    'text-[10px] leading-none',
                                    'text-gray-400'           => $active->pivot->cycle == 1,
                                    'font-bold text-amber-600' => $active->pivot->cycle != 1,
                                ]) title="Cycle: {{ $active->pivot->cycle }} barang per pembacaan">×{{ $active->pivot->cycle }}</span>
                            </div>
                        @else
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-300" title="Off">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </span>
                        @endif
                    </td>
                @endforeach
                {{-- Cycle/Tact --}}
                <td class="px-2 py-3 text-center whitespace-nowrap font-mono text-xs text-gray-700">
                    {{ $item->cycle_time }}<span class="text-gray-400">s</span>
                </td>
                {{-- Threshold (LCL – UCL) --}}
                <td class="px-2 py-3 text-center whitespace-nowrap font-mono text-xs text-gray-700">
                    {{ $item->min_time }}<span class="text-gray-400">s</span>
                    <span class="mx-0.5 text-gray-300">–</span>
                    {{ $item->max_time }}<span class="text-gray-400">s</span>
                </td>
                {{-- Except Time --}}
                <td class="px-2 py-3 text-center whitespace-nowrap" title="Data dengan durasi di bawah {{ $item->except_time }}s tidak ditampilkan">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">
                        &lt; {{ $item->except_time }}s
                    </span>
                </td>
                {{-- Actions --}}
                <td class="px-3 py-3">
                    <x-table.action-hover>
                        {{-- Button Edit --}}
                        <x-button-group variant="info" class="!rounded-full">
                            <button data-modal-open="edit-pattern-modal-{{ $item->id }}" type="button" title="Edit" class="!w-8">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </x-button-group>
                        {{-- Button Delete --}}
                        <form action="{{ route('cycletimes.setting.destroy', $item->id) }}" method="POST" aria-label="Delete Pattern"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pattern: {{ $item->name }}?')">
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
        @empty
            {{-- Table Empty --}}
            <x-table.empty :colspan="count($headers)" message="No patterns registered yet." />
        @endforelse
    </x-table>

    {{-- ===== MODALS ===== --}}
    <x-modal.pages.create-pattern :sensors="$sensors" />
    @foreach ($patterns as $item)
        <x-modal.pages.edit-pattern :item="$item" :sensors="$sensors" />
    @endforeach
</div>
