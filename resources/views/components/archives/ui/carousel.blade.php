@props([
    'id' => 'carousel',
    'interval' => 15000
])

<div id="{{ $id }}"
     class="relative w-full h-full"
     data-carousel="slide"
     data-carousel-interval="{{ $interval }}">

    <!-- Slides -->
    <div class="relative h-full overflow-hidden">
        {{ $slot }}
    </div>

    <!-- Indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-3 left-1/2 space-x-3">
        <button data-carousel-slide-to="0" class="w-3 h-3 rounded-full bg-gray-300"></button>
        <button data-carousel-slide-to="1" class="w-3 h-3 rounded-full bg-gray-300"></button>
    </div>

    <!-- Prev -->
    <button data-carousel-prev
        class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4">
        <span class="text-gray-500 text-2xl">‹</span>
    </button>

    <!-- Next -->
    <button data-carousel-next
        class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4">
        <span class="text-gray-500 text-2xl">›</span>
    </button>
</div>
