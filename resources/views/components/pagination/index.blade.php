@props([
    'paginator',
    'variant' => 'simple',
    'label'   => 'item',
])

@if ($variant === 'numbered')
    <x-pagination.numbered :paginator="$paginator" :label="$label" {{ $attributes }} />
@else
    <x-pagination.simple :paginator="$paginator" :label="$label" {{ $attributes }} />
@endif