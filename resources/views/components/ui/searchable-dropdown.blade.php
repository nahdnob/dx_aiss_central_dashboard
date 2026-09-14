@php
    $buttonId   = "dropdown-{$id}-button";
    $dropdownId = "dropdown-{$id}-search";
    $searchId   = "dropdown-{$id}-search-input";
    $hiddenId   = "dropdown-{$id}-hidden";
    $textId     = "dropdown-{$id}-text";
@endphp

<div data-searchable-dropdown="{{ $id }}">
    <button
        id="{{ $buttonId }}"
        data-dropdown-toggle="{{ $dropdownId }}"
        data-dropdown-placement="bottom"
        type="button"
        class="inline-flex items-center justify-between w-full text-gray-600 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-sky-300 shadow-sm font-medium border border-gray-300 rounded-lg text-sm px-4 py-2.5 focus:outline-none transition"
    >
        <span id="{{ $textId }}" class="flex-1 text-left truncate">
            {{ $selectedLabel ?? $placeholder }}
        </span>
        <svg class="w-4 h-4 ms-2 -me-0.5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
        </svg>
    </button>

    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $hiddenId }}"
        value="{{ $selectedValue }}"
        @if($required) required @endif
    >

    {{-- Flowbite Dropdown menu --}}
    <div id="{{ $dropdownId }}" class="z-50 hidden bg-white border border-gray-200 rounded-lg shadow-lg">
        <div class="border-b border-gray-100 p-2.5">
            <label for="{{ $searchId }}" class="sr-only">Search</label>
            <input
                type="text"
                id="{{ $searchId }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-400 focus:border-sky-400 block w-full px-3 py-2 placeholder:text-gray-400"
                placeholder="{{ $searchPlaceholder }}"
                autocomplete="off"
            />
        </div>
        <ul class="max-h-48 p-1.5 text-sm overflow-y-auto" aria-labelledby="{{ $buttonId }}">
            {{ $slot }}
        </ul>
    </div>
</div>