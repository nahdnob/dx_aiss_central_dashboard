<div class="mb-6">
    <x-layout.section-title eyebrow="Operations Input" title="New Claim Entry" />
    <x-ui.card class="p-5">
        <form action="{{ route('best-records.store') }}" method="POST">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3 items-end">
                <x-form.input name="date" label="Occurrence Date" type="date" required />
                <x-form.input name="claim" label="Claim Description" placeholder="Specify technical issue..." required class="flex-[2]" />
                <x-form.input name="action" label="Action Taken" placeholder="Resolution status..." required class="flex-[2]" />
                <div class="shrink-0 w-full sm:w-auto">
                    <x-ui.button variant="success" type="submit" class="w-full sm:w-auto">
                        Add
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </x-ui.button>
                </div>
            </div>
        </form>
    </x-ui.card>
</div>