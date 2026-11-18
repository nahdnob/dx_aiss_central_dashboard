@props(['item', 'sensors'])

@php
    $itemId  = data_get($item, 'id', '');
    $modalId = 'edit-pattern-modal-' . $itemId;
@endphp

<x-modal :id="$modalId" maxWidth="max-w-2xl">

    <x-modal.partials.header title="Edit Pattern" description="Update the name, sensor positions, and cycle time limits. Fields marked * are required." />

    <form method="POST" action="{{ route('cycletimes.setting.update', $itemId) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="max-h-[65vh] overflow-y-auto pr-1">
            <x-form.pattern-fields :sensors="$sensors" :pattern="$item" :prefix="'pattern-' . $itemId" />
        </div>

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            :prefix="'pattern-' . $itemId"
            submit-label="Save Changes" />
    </form>
</x-modal>
