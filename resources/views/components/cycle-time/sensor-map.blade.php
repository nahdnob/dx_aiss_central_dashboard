@props([
    'path' => 'img/sensor-mapping.png',
])

@php
    $hasMap = file_exists(public_path($path));
@endphp

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col']) }}>
    <x-layout.section-title eyebrow="Layout" title="Sensor Mapping" />
    <x-ui.card class="flex-1 flex flex-col overflow-hidden">
        {{-- Toolbar: description & upload button --}}
        <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-500">Position of each sensor on the production line.</p>
            <form action="{{ route('cycletimes.setting.upload-map') }}" method="POST" enctype="multipart/form-data" class="shrink-0">
                @csrf
                <input type="file" name="map_image" id="map_image_input" accept="image/jpeg,image/png,image/webp" class="hidden"
                       onchange="this.form.submit()">
                <x-ui.button variant="info" onclick="document.getElementById('map_image_input').click()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Upload Map
                </x-ui.button>
            </form>
        </div>
        {{-- Map Preview --}}
        {{-- Tinggi mengikuti kolom kanan (tabel pattern) di layar xl; min-h hanya untuk layar kecil (bertumpuk) --}}
        <div class="flex-1 p-4 flex">
            <div onclick="document.getElementById('map_image_input').click()"
                 class="group relative flex-1 min-h-[320px] xl:min-h-0 flex flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 text-gray-400 cursor-pointer transition-all hover:border-sky-300 hover:bg-sky-50/30">
                @if ($hasMap)
                    <img src="{{ asset($path) }}?v={{ filemtime(public_path($path)) }}" alt="Sensor Map"
                         class="absolute inset-0 w-full h-full object-contain p-2">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="flex items-center gap-2 font-semibold text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Change Map Image
                        </span>
                    </div>
                @else
                    <svg class="w-10 h-10 mb-2 text-gray-300 group-hover:text-sky-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-medium group-hover:text-sky-500 transition-colors">Click here to upload Sensor Map</span>
                    <span class="mt-1 text-xs text-gray-400">Recommended size: 1200x500px, formats: JPG, PNG, WEBP</span>
                @endif
            </div>
        </div>
    </x-ui.card>
</div>
