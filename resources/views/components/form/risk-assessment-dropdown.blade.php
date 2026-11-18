@props([
    'id',
    'riskAssessments' => [],
    'selected'        => null,
    'label'           => 'Risk Assessment',
])

<div {{ $attributes->merge(['class' => 'flex-1 min-w-0']) }}>
    <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">{{ $label }}</label>
    <x-form.searchable-dropdown
        :id="$id"
        name="ra_id"
        placeholder="Select Risk Assessment"
        search-placeholder="Search RA..."
        :selected-value="$selected?->id"
        :selected-label="$selected ? $selected->ra_no . ' - ' . $selected->name : null">
        {{-- No Selection --}}
        <li>
            <a href="#" data-id="" data-value=""
               class="dropdown-option flex flex-col px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                <span class="text-gray-400 italic text-sm">— No selection —</span>
            </a>
        </li>
        {{-- Options --}}
        @foreach ($riskAssessments as $ra)
            <li>
                <a href="#" data-id="{{ $ra->id }}" data-value="{{ $ra->ra_no }} - {{ $ra->name }}"
                   class="dropdown-option flex flex-col px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                    <span class="font-semibold text-gray-800 text-sm">{{ $ra->ra_no }}</span>
                    <span class="text-xs text-gray-500">{{ $ra->name }}</span>
                </a>
            </li>
        @endforeach
    </x-form.searchable-dropdown>
    {{ $slot }}
</div>
