@props([
    'variant' => 'success',
    'type'    => 'submit'
])

@php
    $variants = [
        'success' => 'from-emerald-500 to-teal-600 shadow-emerald-200',
        'info'    => 'from-sky-500 to-sky-600 shadow-sky-200',
        'danger'  => 'from-red-500 to-red-600 shadow-red-200',
    ];
@endphp

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 bg-gradient-to-r text-white font-bold text-sm px-5 py-2.5 rounded-lg shadow-sm hover:brightness-110 transition whitespace-nowrap uppercase ' . $variants[$variant]]) }}>
    {{ $slot }}
</button>