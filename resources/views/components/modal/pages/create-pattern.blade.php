@props(['sensors'])

@php
    $modalId = 'create-pattern-modal';
@endphp

<x-modal :id="$modalId" maxWidth="max-w-2xl">

    <x-modal.partials.header title="Add New Pattern" description="Set the sensor positions and cycle time limits. Fields marked * are required." />

    <form method="POST" action="{{ route('cycletimes.setting.store') }}" class="space-y-4">
        @csrf

        <div class="max-h-[65vh] overflow-y-auto pr-1">
            <x-form.pattern-fields :sensors="$sensors" prefix="pattern-create" />
        </div>

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            prefix="pattern-create"
            submit-label="Save Pattern" />
    </form>
</x-modal>
