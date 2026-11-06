@props([
    'action',
    'name'        => 'search',
    'placeholder' => 'Search...',
])

<form method="GET" action="{{ $action }}" class="flex items-center gap-2 flex-1 max-w-lg">
    <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input type="search"
               name="{{ $name }}"
               value="{{ request($name) }}"
               placeholder="{{ $placeholder }}"
               class="placeholder:text-gray-400 block w-full pl-9 pr-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
    </div>
    <x-button type="submit" class="shrink-0">Search</x-button>
    @if (request($name))
        <x-button variant="secondary" :href="$action" class="shrink-0">Reset</x-button>
    @endif
</form>