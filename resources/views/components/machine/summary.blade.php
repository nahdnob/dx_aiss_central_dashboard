@props(['machine'])

<div class="mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <img
                    src="{{ $machine->image_path ? asset('storage/machines/images/' . $machine->image_path) : asset('assets/images/default-machine.jpg') }}"
                    alt="{{ $machine->asset_name }}"
                    class="h-16 w-16 rounded-xl object-cover border border-gray-200 bg-gray-50"
                >
                <div>
                    <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Machine</p>
                    <h3 class="text-lg font-bold text-gray-900">{{ $machine->asset_name }}</h3>
                    <p class="font-mono text-sm text-gray-500">{{ $machine->asset_no }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm sm:min-w-[280px]">
                <div class="rounded-xl bg-gray-50 px-3 py-2">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Model</p>
                    <p class="mt-1 font-semibold text-gray-700">{{ $machine->model ?? '-' }}</p>
                </div>
                <div class="rounded-xl bg-gray-50 px-3 py-2">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Manufacturer</p>
                    <p class="mt-1 font-semibold text-gray-700">{{ $machine->manufacturer ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
