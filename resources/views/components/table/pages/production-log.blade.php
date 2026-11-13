@props(['datas'])

<div>
    {{-- Title and Description --}}
    <div class="flex items-end justify-between">
        <x-layout.section-title eyebrow="Production Log" title="Part Tracking" />
    </div>
    {{-- ===== TABLE PRODUCTION LOG ===== --}}
    <x-table :headers="['PCB ID', 'Part Number', 'Time In', 'Kanban ID', 'Time Out']">
        {{-- Table Header --}}
        <x-slot:toolbar>
            <x-table.search :action="route('products.index')" placeholder="Search part number..." />
        </x-slot:toolbar>
        {{-- Table Body --}}
        @forelse ($datas as $item)
            <tr class="hover:bg-red-50/40 transition-colors duration-150 group">
                <td class="px-5 py-4 text-gray-600">{{ $item->part_id }}</td>
                <td class="px-5 py-4 text-gray-600 text-center">{{ $item->part_number }}</td>
                <td class="px-5 py-4 text-gray-600 text-center">
                    {{ $item->time_in ? \Carbon\Carbon::parse($item->time_in)->format('Y-m-d H:i') : '-' }}
                </td>
                <td class="px-5 py-4 text-gray-600">{{ $item->productOut->tag_id ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-600 text-center">
                    {{ $item->productOut?->time_out ? \Carbon\Carbon::parse($item->productOut->time_out)->format('Y-m-d H:i') : '-' }}
                </td>
            </tr>
        {{-- Empty State --}}
        @empty
            <x-table.empty colspan="5" message="No production log data available." />
        @endforelse
        {{-- Table Footer --}}
        <x-slot:footer>
            <x-pagination :paginator="$datas" variant="numbered" />
        </x-slot:footer>
    </x-table>
</div>