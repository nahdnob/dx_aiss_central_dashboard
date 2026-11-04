@props([
    'name',
    'label'    => null,
    'type'     => 'text',
    'value'    => null,
    'required' => false
])

@php
    $id    = $attributes->get('id', $name);
    $state = $errors->has($name) ? 'border-red-400 focus:ring-red-400' : 'border-gray-200 focus:ring-sky-400';
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

    <input
        type  ="{{ $type }}"
        id    ="{{ $id }}"
        name  ="{{ $name }}"
        value ="{{ old($name, $value) }}"
        @required($required)
        {{ $attributes->except('class')->merge(['class' => "w-full border rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:border-transparent transition $state",]) }}
    >

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>