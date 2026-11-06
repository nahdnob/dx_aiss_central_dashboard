<div {{ $attributes->merge(['class' => 'flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity duration-150']) }}>
    {{ $slot }}
</div>