@props(['matrix'])

@php
    $cell = fn ($value) => $value > 0 ? $value : '-';
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden h-full flex flex-col']) }}>
    <div class="px-2 py-3 border-b border-gray-100 flex items-center justify-between shrink-0">
        <h3 class="font-bold text-gray-900 text-sm tracking-tight flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
            <span class="text-sm font-bold text-slate-700 uppercase">Degree of Security Rank / RA Level</span>
        </h3>
    </div>
    <div class="overflow-x-auto flex-1">
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="bg-gray-700 border-b-2 border-gray-800 text-white text-center font-bold text-xs tracking-wide uppercase">
                    <th class="py-3 px-2 text-left border-r border-gray-600 pl-4">Rank</th>
                    @foreach (['I', 'II', 'III', 'IV'] as $level)
                        <th class="py-3 px-2 border-r border-gray-600 w-12">{{ $level }}</th>
                    @endforeach
                    <th class="py-2 px-2 w-24 leading-tight text-[10px]">SOP without RA</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-center">
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-2 py-3 text-left font-bold text-slate-700 border-r border-gray-200 pl-4">A</td>
                    @foreach ([1, 2, 3, 4] as $level)
                        <td class="px-2 py-3 border-r border-gray-200 text-lg font-medium text-slate-700">{{ $cell($matrix['A'][$level]) }}</td>
                    @endforeach
                    <td class="px-2 py-3 bg-gray-50"></td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-2 py-3 text-left font-bold text-slate-700 border-r border-gray-200 pl-4">(C)</td>
                    @foreach ([1, 2, 3, 4] as $level)
                        <td class="px-2 py-3 border-r border-gray-200 text-lg font-medium text-slate-700">{{ $cell($matrix['C'][$level]) }}</td>
                    @endforeach
                    <td class="px-2 py-3 bg-gray-50"></td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-2 py-3 text-left font-bold text-slate-700 border-r border-gray-200 pl-4">E</td>
                    @foreach ([1, 2, 3, 4] as $level)
                        <td class="px-2 py-3 bg-gray-50 border-r border-gray-200"></td>
                    @endforeach
                    <td class="px-2 py-3 text-lg font-medium text-slate-700">{{ $cell($matrix['E']['no_ra']) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
