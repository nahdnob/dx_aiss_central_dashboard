@props([
    'variant' => 'info',
    'type'    => 'button',
    'href'    => null,
    'icon'    => false,
])

@php
    $variants = [
        'success'   => 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-sm shadow-emerald-200 hover:brightness-110',
        'info'      => 'bg-gradient-to-r from-sky-500 to-sky-600 text-white shadow-sm shadow-sky-200 hover:brightness-110',
        'danger'    => 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-sm shadow-red-200 hover:brightness-110',
        'secondary' => 'bg-gray-100 text-gray-600 hover:bg-gray-200',
    ];

    // Tombol berlabel: ikon (svg) selalu tampil di KIRI label, apa pun urutannya di markup
    $size = $icon
        ? 'justify-center w-8 h-8 rounded-full'
        : 'gap-2 text-sm px-5 py-2.5 rounded-lg uppercase [&>svg]:order-first [&>svg]:shrink-0';

    $classes = "inline-flex items-center font-bold transition whitespace-nowrap {$size} {$variants[$variant]}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif