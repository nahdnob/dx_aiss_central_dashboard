@props(['href', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->class([
       'text-sm py-1.5 px-3 rounded-lg transition-colors duration-150',
       'text-red-600 bg-red-50 font-semibold' => $active,
       'text-gray-500 hover:text-red-500 hover:bg-gray-50' => ! $active,
   ]) }}>
    {{ $slot }}
</a>