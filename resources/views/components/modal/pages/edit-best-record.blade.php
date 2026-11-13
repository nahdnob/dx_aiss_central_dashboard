@props(['item'])

@php
    $itemId  = data_get($item, 'id', '');
    $modalId = 'edit-best-records-modal-' . $itemId;
@endphp

<x-modal :id="$modalId" maxWidth="max-w-lg">

    <x-modal.partials.header title="Edit Best Record"  description="Update the line performance details below." />

    <form method="POST" action="{{ route('best-records.update', data_get($item, 'id', 0)) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ $itemId }}">

        <x-form.input
            id="best-record-date-{{ $itemId }}"
            name="date" type="date" label="Occurrence Date"
            class="mb-4"
            :value="data_get($item, 'date', '')"
            :required="true" />

        <x-form.input
            id="best-record-claim-{{ $itemId }}"
            name="claim" label="Claim Description"
            class="mb-4"
            :value="data_get($item, 'claim', '')"
            :required="true" />

        <x-form.input
            id="best-record-action-{{ $itemId }}"
            name="action" label="Action Taken"
            class="mb-4"
            :value="data_get($item, 'action', '')"
            :required="true" />

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            :prefix="'best-record-' . $itemId"
            submit-label="Save Changes" />
    </form>
</x-modal>