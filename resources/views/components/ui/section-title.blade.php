@props([
    'eyebrow',
    'title'
])

<div {{ $attributes->merge(['class' => 'ml-2 mb-3']) }}>
    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">{{ $eyebrow }}</p>
    <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
</div>