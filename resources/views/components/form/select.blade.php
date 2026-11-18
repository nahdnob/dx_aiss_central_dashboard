@props([
    'name',
    'label'       => null,
    'options'     => [],
    'value'       => null,
    'placeholder' => null,
    'required'    => false
])

@php
    $id       = $attributes->get('id', $name);
    $selected = (string) old($name, $value);
    $state    = $errors->has($name) ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-sky-400';
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'flex-1 min-w-0']) }}>
    @if ($label)
        <label for="{{ $id }}" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select
        id   ="{{ $id }}"
        name ="{{ $name }}"
        @required($required)
        {{ $attributes->except(['class', 'id'])->merge(['class' => "w-full border rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:border-transparent transition $state"]) }}
    >
        @if (!is_null($placeholder))
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) $optionValue === $selected)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
