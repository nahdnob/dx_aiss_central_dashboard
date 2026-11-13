@props(['variant' => 'info'])

@php
    $variants = [
        'success' => 'from-emerald-500 to-teal-600',
        'info'    => 'from-sky-500 to-sky-600',
        'danger'  => 'from-red-500 to-red-600',
    ];
@endphp

<div {{ $attributes->merge([
    'class' => 'inline-flex items-center rounded-full bg-gradient-to-r overflow-hidden shadow-sm divide-x divide-white/30 '
             . '[&>*]:w-10 [&>*]:h-8 [&>*]:flex [&>*]:items-center [&>*]:justify-center [&>*]:text-white [&>*]:transition hover:[&>*]:bg-white/10 '
             . $variants[$variant],]) }}>

    {{ $slot }}
</div>