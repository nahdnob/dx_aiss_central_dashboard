@props(['item', 'lines' => []])

@php
    $itemId  = data_get($item, 'id', '');
    $modalId = 'edit-dasg-modal-' . $itemId;
    $link    = data_get($item, 'link');
@endphp

<x-modal :id="$modalId" maxWidth="max-w-lg">

    <x-modal.partials.header title="Edit DASg" description="Update the DASg details below and save changes." />

    <form method="POST" action="{{ route('dasgs.update', $itemId) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <x-form.input
            id="dasg-name-{{ $itemId }}"
            name="name" label="Document Name"
            placeholder="Enter document name"
            :value="data_get($item, 'name', '')"
            :required="true" />

        <x-form.input
            id="dasg-detail-standard-{{ $itemId }}"
            name="detail_standard" label="Detail Standard"
            placeholder="Standard detail"
            :value="data_get($item, 'detail_standard', '')" />

        <x-form.input
            id="dasg-revision-{{ $itemId }}"
            name="revision" label="Revision" type="number" min="1"
            :value="data_get($item, 'revision', '')"
            :required="true" />

        <x-form.file-input
            id="dasg-file-{{ $itemId }}"
            name="dasg_file" label="Upload File (Optional)"
            accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx"
            :placeholder="$link ? basename($link) : 'No file selected'" />

        <x-form.select
            id="dasg-line-{{ $itemId }}"
            name="line_id" label="Line"
            placeholder="Choose Line"
            :options="collect($lines)->pluck('name', 'id')"
            :value="data_get($item, 'line_id')" />

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            :prefix="'dasg-' . $itemId"
            submit-label="Save Changes" />
    </form>
</x-modal>
