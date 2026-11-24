{{--
    Scroll Control — kontrol scroll melayang (glass / transparan) di pojok kanan.

    Pemakaian:
        <x-utility.scroll-control />
        <x-utility.scroll-control :auto="false" :speed="200" :pause="10000" />

    Props:
        auto   (bool) mulai dengan auto-scroll bolak-balik atas <-> bawah
        speed  (int)  kecepatan auto-scroll, px per detik
        pause  (int)  standby di ujung atas/bawah sebelum scroll kembali, ms
        resume (int)  auto lanjut lagi setelah user berhenti scroll manual, ms

    Warna merah menandai ujung (atas/bawah) yang terakhir dicapai.
--}}
@props([
    'auto'   => true,
    'speed'  => 500,
    'pause'  => 15000,
    'resume' => 5000,
])

<div
    x-data="scrollControl({ auto: @js((bool) $auto), speed: @js((int) $speed), pause: @js((int) $pause), resume: @js((int) $resume) })"
    x-show="scrollable"
    x-transition.opacity.duration.300ms
    x-cloak
    @mouseenter="hovering = true"
    @mouseleave="hovering = false"
    {{ $attributes->merge(['class' => 'fixed right-3 top-1/2 -translate-y-1/2 z-40 select-none print:hidden']) }}
>
    <div class="group flex flex-col items-center gap-1 rounded-full px-1 py-1.5
                bg-white/10 backdrop-blur-sm backdrop-saturate-150
                border border-white/25 ring-1 ring-black/[0.03]
                shadow-[0_4px_14px_rgba(15,23,42,0.08)]
                opacity-40 hover:opacity-100 transition-opacity duration-300">

        {{-- Tombol ke atas --}}
        <button type="button" @click="toTop()" title="Scroll ke atas"
                class="relative grid place-items-center size-4 rounded-full text-white
                       ring-1 ring-offset-1 ring-offset-transparent
                       transition-all duration-500 hover:scale-110 active:scale-95 focus:outline-none"
                :class="edge === 'top'
                    ? 'bg-red-600 ring-red-500/70 shadow-[0_0_6px_rgba(220,38,38,0.5)]'
                    : 'bg-slate-900 ring-transparent'">
            <svg class="size-2.5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
            </svg>
        </button>

        {{-- Track progres posisi scroll --}}
        <div class="relative w-px h-5 rounded-full bg-slate-900/20 overflow-hidden">
            <div class="absolute inset-x-0 top-0 rounded-full bg-red-600 transition-[height] duration-150"
                 :style="`height: ${Math.round(progress * 100)}%`"></div>
        </div>

        {{-- Tombol ke bawah --}}
        <button type="button" @click="toBottom()" title="Scroll ke bawah"
                class="relative grid place-items-center size-4 rounded-full text-white
                       ring-1 ring-offset-1 ring-offset-transparent
                       transition-all duration-500 hover:scale-110 active:scale-95 focus:outline-none"
                :class="edge === 'bottom'
                    ? 'bg-red-600 ring-red-500/70 shadow-[0_0_6px_rgba(220,38,38,0.5)]'
                    : 'bg-slate-900 ring-transparent'">
            <svg class="size-2.5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- Toggle auto-scroll --}}
        <button type="button" @click="toggleAuto()"
                :title="auto ? 'Jeda auto-scroll' : 'Jalankan auto-scroll'"
                class="grid place-items-center size-3.5 rounded-full text-slate-700
                       bg-white/30 hover:bg-white/80 transition-colors focus:outline-none">
            <svg x-show="auto" class="size-2" viewBox="0 0 24 24" fill="currentColor">
                <rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/>
            </svg>
            <svg x-show="!auto" class="size-2" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8 5.14v13.72a1 1 0 0 0 1.5.86l11-6.86a1 1 0 0 0 0-1.72l-11-6.86A1 1 0 0 0 8 5.14z"/>
            </svg>
        </button>
    </div>
</div>
