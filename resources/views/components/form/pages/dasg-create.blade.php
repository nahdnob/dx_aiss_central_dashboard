<div class="mb-6">
    <x-layout.section-title eyebrow="Operations Input" title="New DASg Document" />
    <x-ui.card class="p-5">
        <form action="{{ route('dasgs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3 items-end">
                <x-form.input name="name" label="Name" placeholder="D0123..." required />
                <x-form.input name="detail_standard" label="Detail Standard" placeholder="Standard to do ..." />
                <x-form.file-input name="dasg_file" label="Choose File" accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx" placeholder="No file selected" required />
                <div class="shrink-0 w-full sm:w-auto">
                    <x-ui.button variant="success" type="submit" class="w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add
                    </x-ui.button>
                </div>
            </div>
        </form>
    </x-ui.card>
</div>
