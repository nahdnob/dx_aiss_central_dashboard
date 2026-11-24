@props([
    'user',
    'size' => 'w-9 h-9',
])

{{-- Foto user; jika tidak ada, tampilkan inisial nama --}}
@if (data_get($user, 'image'))
    <img src="{{ \Illuminate\Support\Facades\Storage::url($user->image) }}" alt="{{ $user->name }}"
        {{ $attributes->merge(['class' => "$size rounded-full object-cover ring-2 ring-gray-100 shrink-0"]) }}>
@else
    <div {{ $attributes->merge(['class' => "$size rounded-full bg-gradient-to-br from-red-400 to-rose-600 flex items-center justify-center shrink-0"]) }}>
        <span class="text-white font-bold text-xs uppercase">{{ mb_substr(data_get($user, 'name', ''), 0, 1) }}</span>
    </div>
@endif
