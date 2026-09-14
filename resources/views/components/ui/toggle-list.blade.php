@props([
    'itemId',
    'items',
    'connectedIds' => [],
    'inputName'    => 'item_ids[]',
    'label'        => 'Connection',
    'searchPlaceholder' => 'Search...',
    'nameKey'      => 'name',
    'subKey'       => null,
])

<div class="flex flex-col overflow-hidden h-full">
    <div class="flex items-center justify-between mb-2">
        <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase">{{ $label }}</label>
        <span class="text-[10px] text-gray-400">Toggle to connect</span>
    </div>

    {{-- Search --}}
    <div class="mb-2">
        <input
            type="text"
            class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-2 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 transition"
            placeholder="{{ $searchPlaceholder }}"
            autocomplete="off"
            data-toggle-search="{{ $itemId }}"
        />
    </div>

    {{-- List --}}
    <div
        class="border border-gray-200 rounded-xl overflow-hidden divide-y divide-gray-100 flex-1 overflow-y-auto"
        data-toggle-list="{{ $itemId }}"
    >
        @forelse($items as $item)
            @php
                $isConnected = in_array($item->id, $connectedIds);
                $nameVal     = $item->{$nameKey};
                $subVal      = $subKey ? ($item->{$subKey} ?? '-') : null;
                $searchData  = strtolower($nameVal . ($subVal ? ' ' . $subVal : ''));
            @endphp
            <label
                class="toggle-list-item flex items-center justify-between gap-3 px-3 py-3 cursor-pointer hover:bg-gray-50 transition"
                data-name="{{ $searchData }}"
            >
                <div class="flex flex-col flex-1 min-w-0">
                    <span class="text-sm font-semibold text-gray-800 truncate">{{ $nameVal }}</span>
                    @if($subVal)
                        <span class="text-xs text-gray-400 truncate">{{ $subVal }}</span>
                    @endif
                </div>
                <div class="relative shrink-0">
                    <input
                        type="checkbox"
                        name="{{ $inputName }}"
                        value="{{ $item->id }}"
                        class="sr-only peer"
                        id="toggle_{{ $itemId }}_{{ $item->id }}"
                        {{ $isConnected ? 'checked' : '' }}
                    >
                    <label
                        for="toggle_{{ $itemId }}_{{ $item->id }}"
                        class="flex items-center w-10 h-5 bg-gray-200 rounded-full cursor-pointer peer-checked:bg-sky-500 transition-colors duration-200 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:w-4 after:h-4 after:transition-all peer-checked:after:translate-x-5"
                    ></label>
                </div>
            </label>
        @empty
            <div class="px-4 py-6 text-center text-sm text-gray-400">No data available</div>
        @endforelse
    </div>
</div>