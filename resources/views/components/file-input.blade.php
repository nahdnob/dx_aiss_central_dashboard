@props([
    'name',
    'label' => 'Images',
    'accept' => 'image/*',
    'placeholder' => 'No file chosen',
])

@php($id = $attributes->get('id', $name))

<div class="flex-1 min-w-0 w-full" data-file-input>
    <label for="{{ $id }}" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">
        {{ $label }}
    </label>

    <div class="flex items-center gap-3 border border-gray-200 rounded-lg px-1.5 py-1.5 bg-gray-50 hover:border-gray-300 transition">
        <button type="button" data-file-button
            class="shrink-0 px-4 py-1.5 bg-white border border-gray-200 text-gray-700 font-semibold text-xs rounded-lg transition whitespace-nowrap shadow-sm">
            Browse File
        </button>

        <span data-file-name data-placeholder="{{ $placeholder }}" class="text-sm text-gray-500 flex-1 truncate">
            {{ $placeholder }}
        </span>

        <input type="file" id="{{ $id }}" name="{{ $name }}" accept="{{ $accept }}"
            {{ $attributes->except('id')->merge(['class' => 'hidden']) }}>
    </div>
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-file-button]');
            if (btn) btn.closest('[data-file-input]').querySelector('input[type=file]').click();
        });

        document.addEventListener('change', (e) => {
            if (!e.target.matches('[data-file-input] input[type=file]')) return;
            const span = e.target.closest('[data-file-input]').querySelector('[data-file-name]');
            span.textContent = e.target.files.length > 0
                ? e.target.files[0].name
                : span.dataset.placeholder;
        });
    </script>
    @endpush
@endonce