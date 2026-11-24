@props([
    'href',
    'active' => false,
    'title'  => null
])

<a href="{{ $href }}"
   title="{{ $title }}"
   {{ $attributes->class([
       'flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer',
       'bg-red-500/10 text-red-600 border-l-[3px] border-red-600 pl-[7px]' => $active,
       'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' => ! $active,
   ]) }}>
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {{ $icon }}
    </svg>
    <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">
        {{ $slot }}
    </span>
</a>