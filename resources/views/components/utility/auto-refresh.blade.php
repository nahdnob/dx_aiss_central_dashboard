@props(['url', 'interval' => 5000])

<div data-refresh-url="{{ $url }}" data-refresh-interval="{{ $interval }}" {{ $attributes }}>
    {{ $slot }}
</div>

@pushOnce('scripts')
    @vite('resources/js/entries/autoRefresh.js')
@endPushOnce