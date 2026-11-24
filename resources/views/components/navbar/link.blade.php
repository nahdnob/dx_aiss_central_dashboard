<a
    @props(['active' => false])
    {{ $attributes }}
    class="{{ $active ? 'bg-gray-900 text-white' : 'text-white hover:bg-gray-700 hover:text-white' }}
        rounded-md
        px-3
        py-2
        text-sm
        font-medium"
    aria-current="{{ $active ? 'page' : 'false'}}">{{ $slot }}
</a>