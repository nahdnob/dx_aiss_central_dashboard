@props([
    'title',
    'image'       => null,
    'alt'         => null,
    'breadcrumbs' => [],
    'fallback'    => 'assets/images/default-machine.jpg',
])

@php
    $fallbackUrl = asset($fallback);

    $src = $image
        ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://', '/'])
            ? $image
            : asset($image))
        : $fallbackUrl;
@endphp

<div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
    {{-- Image --}}
    <div class="absolute left-0 top-0 h-full w-[420px] z-10">
        <img src="{{ $src }}"
             alt="{{ $alt ?? $title }}"
             class="w-full h-full object-cover"
             onerror="this.onerror=null;this.src='{{ $fallbackUrl }}';">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
    </div>
    {{-- Decorative --}}
    <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-red-50 to-transparent z-20"></div>
    <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-red-500/10 blur-3xl z-30"></div>
    <div class="absolute right-20 top-1/2 -translate-y-1/2 w-24 h-24 rounded-full bg-red-100/50 z-30"></div>
    {{-- Content --}}
    <div class="relative z-40 px-8 py-5 pl-[380px] min-h-[140px] flex flex-col justify-center">
        @if (!empty($breadcrumbs))
            <x-layout.breadcrumb :items="$breadcrumbs" />
        @endif

        <h1 class="text-2xl font-bold text-gray-900 tracking-tight uppercase">
            {{ $title }}
        </h1>

        @if (!$slot->isEmpty())
            <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                {{ $slot }}
            </p>
        @endif
    </div>
</div>