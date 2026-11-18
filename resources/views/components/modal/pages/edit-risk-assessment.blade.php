@props(['item', 'lines' => []])

@php
    $itemId  = data_get($item, 'id', '');
    $modalId = 'edit-ra-modal-' . $itemId;
    $link    = data_get($item, 'link');

    $securityRanks = [
        'A' => 'A: Work does not depend of human',
        'C' => 'C: Work depends of human',
        'E' => 'E: Work with SOP without RA',
    ];
@endphp

<x-modal :id="$modalId" maxWidth="max-w-lg">

    <x-modal.partials.header title="Edit Risk Assessment" description="Update the Risk Assessment details below and save changes." />

    <form method="POST" action="{{ route('risk-assessments.update', $itemId) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <x-form.input
            id="ra-name-{{ $itemId }}"
            name="name" label="Document Name"
            placeholder="Enter document name"
            :value="data_get($item, 'name', '')"
            :required="true" />

        <div class="grid grid-cols-2 gap-3">
            <x-form.input
                id="ra-no-{{ $itemId }}"
                name="ra_no" label="RA No"
                placeholder="e.g. RA-001"
                :value="data_get($item, 'ra_no', '')"
                :required="true" />

            <x-form.input
                id="ra-level-{{ $itemId }}"
                name="ra_level" label="RA Level" type="number" min="1" max="4"
                placeholder="1 - 4"
                :value="data_get($item, 'ra_level', '')" />

            <x-form.select
                id="ra-security-rank-{{ $itemId }}"
                name="ra_security_rank" label="Security Rank"
                placeholder="Select Rank"
                :options="$securityRanks"
                :value="data_get($item, 'ra_security_rank')" />

            <x-form.input
                id="ra-revision-{{ $itemId }}"
                name="revision" label="Revision" type="number" min="1"
                :value="data_get($item, 'revision', '')"
                :required="true" />
        </div>

        <x-form.file-input
            id="ra-file-{{ $itemId }}"
            name="ra_file" label="Upload File (Optional)"
            accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx"
            :placeholder="$link ? basename($link) : 'No file selected'" />

        <x-form.select
            id="ra-line-{{ $itemId }}"
            name="line_id" label="Line"
            placeholder="— No selection —"
            :options="collect($lines)->pluck('name', 'id')"
            :value="data_get($item, 'line_id')" />

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            :prefix="'ra-' . $itemId"
            submit-label="Save Changes" />
    </form>
</x-modal>
