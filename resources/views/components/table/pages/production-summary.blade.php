@props(['products', 'runningId' => null])

<div class="mb-6">
    {{-- Title & Description --}}
    <div class="flex items-end justify-between">
        <x-layout.section-title eyebrow="Production Monitoring" title="Production Progress" />
    </div>
    {{-- ===== TABLE PRODUCTION SUMMARY ===== --}}
    <x-table :headers="['Part Number', 'Time In', 'QTY In', 'Time Out', 'QTY Out', 'Flow']">
        {{-- Table Body --}}
        @forelse ($products as $item)
            @php
                $timeIn  = $item->firstProductIn?->time_in;
                $timeOut = (int) $item->id === (int) $runningId ? null : $item->last_time_out;
                $qtyIn   = $item->qty_in ?? 0;
                $qtyOut  = $item->qty_out ?? 0;
                $flowPct = $qtyIn > 0 ? round(($qtyOut / $qtyIn) * 100, 1) : 0;
                $color   = $flowPct >= 100 ? '#22c55e' : '#3b82f6';
                $deg     = min($flowPct, 100) * 3.6;
            @endphp
            <tr class="hover:bg-red-50/40 transition-colors duration-150 group">
                <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                    <span class="font-semibold text-gray-800">{{ $item->part_number }}</span>
                </td>
                <td class="px-5 py-4 text-gray-600 text-center whitespace-nowrap">
                    {{ $timeIn ? \Carbon\Carbon::parse($timeIn)->format('Y-m-d H:i') : '-' }}
                </td>
                <td class="px-5 py-4 text-gray-600 text-center">
                    {{ $qtyIn ?: '-' }}
                </td>
                <td class="px-5 py-4 text-gray-600 text-center">
                    {{ $timeOut ? \Carbon\Carbon::parse($timeOut)->format('Y-m-d H:i') : '-' }}
                </td>
                <td class="px-5 py-4 text-gray-600 text-center">
                    {{ $qtyOut ?: '-' }}
                </td>
                <td class="px-5 py-4 text-gray-600">
                    <div class="flex items-center justify-between gap-2">
                        <div class="relative w-8 h-8 shrink-0">
                            <div class="w-8 h-8 rounded-full"
                                 style="background: conic-gradient({{ $color }} 0deg {{ $deg }}deg, #f3f4f6 {{ $deg }}deg 360deg);">
                                <div class="absolute inset-[2.5px] rounded-full bg-white"></div>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold {{ $flowPct >= 100 ? 'text-green-600' : 'text-sky-600' }}">{{ $flowPct }}%</span>
                    </div>
                </td>
            </tr>
        {{-- Empty State --}}
        @empty
            <x-table.empty colspan="6" message="No production summary data available." />
        @endforelse
        {{-- Table Footer --}}
        <x-slot:footer>
            <x-pagination :paginator="$products" variant="numbered" />
        </x-slot:footer>
    </x-table>
</div>