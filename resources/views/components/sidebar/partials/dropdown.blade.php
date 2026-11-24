@props(['label', 'active' => false])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button @click="open = !open"
            class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer w-full justify-between {{ $active ? 'text-red-600 font-bold' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {{ $icon }}
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">{{ $label }}</span>
        </div>
        <svg class="w-4 h-4 flex-shrink-0 ml-2 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
             :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" x-collapse
         class="flex flex-col ml-9 mt-1 space-y-1 opacity-0 overflow-hidden transition-opacity duration-200 group-hover:opacity-100">
        {{ $slot }}
    </div>
</div>