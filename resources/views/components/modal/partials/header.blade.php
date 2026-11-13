@props([
    'id'          => null,
    'title',
    'description' => null,
])

<div class="mb-5">
    <h2 @if($id) id="{{ $id }}" @endif class="text-2xl font-extrabold text-slate-800">{{ $title }}</h2>

    @if($description)
        <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
    @endif
</div>