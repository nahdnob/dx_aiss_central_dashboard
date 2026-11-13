@props([
    'id',
    'maxWidth' => 'max-w-md',
    'accent'   => true,
])

<!-- Overlay -->
<div id="{{ $id }}-overlay"
    data-modal-overlay
    class="hidden fixed inset-0 bg-black/50 z-40 transition-opacity duration-300">
</div>

<!-- Modal Wrapper -->
<div id="{{ $id }}"
     role="dialog"
     aria-modal="true"
     {{ $attributes->class([
        'hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2',
        'opacity-0 scale-95 z-50 transition-all duration-300',
        'w-[calc(100%-2rem)]',
        $maxWidth,
     ]) }}>

    {{-- Panel: konsisten untuk semua modal --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-2xl">

        @if($accent)
            {{-- Aksen merah ke biru muda, mengikuti ilustrasi di halaman login --}}
            <div class="h-1.5 bg-gradient-to-r from-red-600 via-rose-400 to-sky-300"></div>
        @endif

        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>