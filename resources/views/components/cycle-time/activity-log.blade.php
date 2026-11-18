@props(['logs', 'total' => 0])

{{-- Recent Activity Log: pembacaan sensor terbaru; jumlah entri dihitung per hari produksi (shift 1 + shift 2) --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden h-full flex flex-col']) }}>
    <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0">
        <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
            <span class="text-sm font-bold text-slate-700 uppercase">Recent Activity Log</span>
        </h3>
        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2.5 py-1 rounded-full border border-gray-150">
            {{ number_format($total) }} entries today
        </span>
    </div>
    <div class="overflow-y-auto flex-1">
        <table class="w-full text-left">
            <thead class="sticky top-0">
                <tr class="bg-gray-700 border-b-2 border-gray-800">
                    <th class="px-5 py-3 text-xs font-bold text-white uppercase tracking-wide">Time</th>
                    <th class="px-5 py-3 text-xs font-bold text-white uppercase tracking-wide">Pos</th>
                    <th class="px-5 py-3 text-xs font-bold text-white uppercase tracking-wide text-center">Duration</th>
                    <th class="px-5 py-3 text-xs font-bold text-white uppercase tracking-wide text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($logs as $log)
                    <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="text-sm font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($log->time)->format('H:i:s') }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ $log->status == 1 ? 'bg-emerald-400' : 'bg-red-400' }}"></div>
                                <span class="text-sm font-medium text-slate-700">{{ $log->pos_label ?? $log->sensor?->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="text-sm font-medium text-slate-700">{{ number_format($log->duration, 2) }}<span class="font-normal text-gray-400 ml-0.5">s</span></span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if($log->status == 1)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> OK
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> NG
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center text-gray-400">
                                <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-sm italic">No activity recorded yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
