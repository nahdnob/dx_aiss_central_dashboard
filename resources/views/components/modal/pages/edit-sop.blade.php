@props(['item', 'riskAssessments' => [], 'dasgs' => []])

@php
    $itemId  = data_get($item, 'id', '');
    $modalId = 'edit-sop-modal-' . $itemId;
    $link    = data_get($item, 'link');
@endphp

<x-modal :id="$modalId" maxWidth="max-w-4xl">

    <x-modal.partials.header title="Edit SOP" description="Update the SOP details below. Fields marked * are required." />

    <form method="POST" action="{{ route('sops.update', $itemId) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="flex flex-col md:flex-row gap-6 max-h-[65vh] overflow-y-auto md:overflow-visible">
            {{-- Left: Fields --}}
            <div class="w-full md:w-96 shrink-0 space-y-4">
                <x-form.input
                    id="sop-name-{{ $itemId }}"
                    name="name" label="Document Name"
                    placeholder="Enter document name" maxlength="255"
                    :value="data_get($item, 'name', '')"
                    :required="true" />

                <div class="grid grid-cols-2 gap-3">
                    <x-form.input
                        id="sop-no-{{ $itemId }}"
                        name="sop_no" label="SOP No"
                        placeholder="e.g. SOP-001" maxlength="50"
                        :value="data_get($item, 'sop_no', '')" />

                    <x-form.input
                        id="sop-revision-{{ $itemId }}"
                        name="revision" label="Revision" type="number" min="1"
                        :value="data_get($item, 'revision', '')"
                        :required="true" />
                </div>

                <div>
                    <x-form.file-input
                        id="sop-file-{{ $itemId }}"
                        name="sop_file" label="SOP File"
                        accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx"
                        :placeholder="$link ? basename($link) : 'No file selected'" />
                    <p class="mt-1 text-xs text-gray-400">
                        PDF, Word, Excel, or PowerPoint · max 10 MB. Leave empty to keep the current file.
                        @if ($link)
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($link) }}" target="_blank" rel="noopener" class="text-sky-600 hover:underline">View current file</a>
                        @endif
                    </p>
                </div>

                <x-form.risk-assessment-dropdown
                    :id="'ra-edit-' . $itemId"
                    :risk-assessments="$riskAssessments"
                    :selected="$item->activeRiskAssessment">
                    <p class="mt-1 text-xs text-gray-400">Optional. Link this SOP to its active risk assessment.</p>
                </x-form.risk-assessment-dropdown>
            </div>

            {{-- Right: DASG Connection --}}
            <div class="flex-1 h-[360px] flex flex-col overflow-hidden">
                <x-form.toggle-list
                    :item-id="$itemId"
                    :items="$dasgs"
                    :connected-ids="$item->dasgs->pluck('id')->toArray()"
                    input-name="dasg_ids[]"
                    label="DASG Connection"
                    search-placeholder="Search DASG..."
                    name-key="name"
                    sub-key="detail_standard" />
            </div>
        </div>

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            :prefix="'sop-' . $itemId"
            submit-label="Save Changes" />
    </form>
</x-modal>
