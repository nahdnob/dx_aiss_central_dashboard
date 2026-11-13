@props(['item'])

@php
    $itemId = data_get($item, 'id', '');
    $modalId = 'edit-line-performance-modal-' . $itemId;
@endphp

<x-modal :id="$modalId" maxWidth="max-w-lg">
    <x-modal.partials.header title="Edit Line Performance" description="Update the line performance details below." />

    <form method="POST" action="{{ route('line-performance.update', $itemId) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <x-form.input
            class="mb-4"
            id="line-performance-month-{{ $itemId }}"
            name="month"
            label="Month"
            :value="data_get($item, 'month', '')"
            :required="true" />

        <x-form.input
            class="mb-4"
            id="line-performance-year-{{ $itemId }}"
            name="year"
            label="Year"
            type="number"
            min="2000"
            max="2100"
            :value="data_get($item, 'year', '')"
            :required="true" />

        <x-form.input
            class="mb-4"
            id="line-performance-target-{{ $itemId }}"
            name="target"
            label="Target (%)"
            type="number"
            min="0"
            max="100"
            step="0.1"
            :value="data_get($item, 'target', '')"
            :required="true" />

        <x-form.input
            class="mb-4"
            id="line-performance-actual-{{ $itemId }}"
            name="actual"
            label="Actual (%)"
            type="number"
            min="0"
            max="100"
            step="0.1"
            :value="data_get($item, 'actual', '')"
            :required="true" />

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            :prefix="'line-performance-' . $itemId"
            submit-label="Save Changes" />
    </form>
</x-modal>
