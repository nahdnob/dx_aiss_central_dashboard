@props(['machine', 'errors'])

<div class="mb-6">
    <x-layout.section-title eyebrow="Machine Details" title="Edit Machine Information" />
    <x-ui.card class="p-5">
        <form action="{{ route('machines.update', $machine->asset_no) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <x-form.input name="asset_no"
                    label="Asset No."
                    :value="$machine->asset_no"
                    readonly
                    class="!text-gray-400 !border-gray-100 font-mono cursor-not-allowed" />
                <x-form.input name="asset_name"
                    label="Asset Name"
                    :value="$machine->asset_name"
                    required />
                <x-form.input name="acquisition_date"
                    label="Acquisition Date"
                    type="date"
                    :value="$machine->acquisition_date?->format('Y-m-d')" />
                <x-form.input name="manufacturer"
                    label="Manufacturer"
                    :value="$machine->manufacturer"
                    placeholder="empty" />
                <x-form.input name="model"
                    label="Model"
                    :value="$machine->model"
                    placeholder="empty" />
                <x-form.file-input name="image_path" :current="$machine->image_path" />
            </div>
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="flex justify-end">
                <x-ui.button type="submit" variant="info">
                    Save
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
