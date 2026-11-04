@props(['lines'])

<x-ui.modal id="line-select-modal" maxWidth="max-w-md">
    <div class="w-full max-w-md overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-2xl">
        {{-- Aksen merah ke biru muda, mengikuti ilustrasi di halaman login --}}
        <div class="h-1.5 bg-gradient-to-r from-red-600 via-rose-400 to-sky-300"></div>

        <div class="p-6">
            {{-- Header --}}
            <div class="mb-5">
                <h2 id="line-modal-title" class="text-2xl font-extrabold text-slate-800">Choose your line</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Dashboard data will be filtered by the line you select. You can switch lines later from the menu.
                </p>
            </div>

            <form id="line-select-form" action="{{ route('line-selector.select') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Error: jelaskan masalah + cara memperbaikinya --}}
                @error('line_id')
                    <div class="flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700" role="alert">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }} Please pick a line from the list below and try again.</span>
                    </div>
                @enderror

                @if($lines->isEmpty())
                    <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-4 py-8 text-center">
                        <p class="text-sm font-medium text-slate-700">No production line is assigned to your account.</p>
                        <p class="mt-1 text-xs text-gray-500">Please contact your system administrator to request access.</p>
                    </div>
                @else
                    {{-- Pencarian muncul hanya jika line banyak --}}
                    @if($lines->count() > 5)
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="search" id="line-search" placeholder="Search line..." autocomplete="off"
                                aria-label="Search production line"
                                class="w-full rounded-full border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-gray-400 focus:border-red-400 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                        </div>
                    @endif

                    <fieldset aria-labelledby="line-modal-title">
                        <legend class="sr-only">Production line</legend>

                        <div id="line-list" class="flex max-h-64 flex-col gap-2 overflow-y-auto pr-1">
                            @foreach($lines as $line)
                                <label for="line_{{ $line->id }}"
                                    data-name="{{ strtolower($line->name . ' ' . optional($line->businessUnit)->name) }}"
                                    class="line-item flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3 transition-colors hover:bg-gray-50
                                        has-[:checked]:border-red-500 has-[:checked]:bg-red-50
                                        has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-red-500/40">

                                    <input type="radio" name="line_id" id="line_{{ $line->id }}" value="{{ $line->id }}"
                                        class="h-4 w-4 shrink-0 cursor-pointer border-gray-300 text-red-600 focus:ring-red-500/30"
                                        @checked((string) old('line_id', $lines->count() === 1 ? $line->id : null) === (string) $line->id)
                                        required>

                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-slate-800 uppercase" title="{{ $line->name }}">{{ $line->name }}</span>
                                        @if($line->businessUnit)
                                            <span class="block truncate text-xs text-gray-500" title="{{ $line->businessUnit->name }}">{{ $line->businessUnit->name }}</span>
                                        @endif
                                    </span>
                                </label>
                            @endforeach

                            <p id="line-no-match" class="hidden px-2 py-4 text-center text-sm text-gray-500">
                                No line matches your search.
                            </p>
                        </div>
                    </fieldset>
                @endif

                <div class="space-y-2 pt-1">
                    <button type="submit" id="line-submit-btn" @disabled($lines->isEmpty())
                        class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-red-600 to-rose-900 px-5 py-3 text-base font-bold text-white shadow-lg shadow-red-500/30 transition-all hover:from-red-700 hover:to-rose-950 focus:outline-none focus:ring-4 focus:ring-red-300 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none">
                        <svg id="line-spinner" class="hidden h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span id="line-submit-label">Continue</span>
                        <svg id="line-arrow" class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0-5-5m5 5-5 5"/>
                        </svg>
                    </button>

                    {{-- Kontrol keluar --}}
                    <button type="button" onclick="window.Modal?.close('line-select-modal')"
                        class="w-full rounded-full px-5 py-2 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>

                <p class="text-center text-[11px] text-gray-400">
                    Can't find your line? Contact your system administrator.
                </p>
            </form>
        </div>
    </div>
</x-ui.modal>

<script>
(function () {
    const form = document.getElementById('line-select-form');
    if (!form) return;

    const btn     = document.getElementById('line-submit-btn');
    const label   = document.getElementById('line-submit-label');
    const spinner = document.getElementById('line-spinner');
    const arrow   = document.getElementById('line-arrow');
    const radios  = form.querySelectorAll('input[name="line_id"]');
    const items   = form.querySelectorAll('.line-item');
    const search  = document.getElementById('line-search');
    const noMatch = document.getElementById('line-no-match');

    // Error prevention: tombol aktif hanya jika ada line terpilih
    function sync() {
        const checked = form.querySelector('input[name="line_id"]:checked');
        btn.disabled = !checked;
    }
    radios.forEach(r => r.addEventListener('change', sync));
    sync();

    // Efisiensi: klik dua kali pada baris langsung melanjutkan
    items.forEach(el => el.addEventListener('dblclick', () => {
        if (!btn.disabled) form.requestSubmit();
    }));

    // Pencarian line
    if (search) {
        search.addEventListener('input', () => {
            const q = search.value.trim().toLowerCase();
            let visible = 0;
            items.forEach(el => {
                const show = el.dataset.name.includes(q);
                el.classList.toggle('hidden', !show);
                if (show) visible++;
            });
            noMatch.classList.toggle('hidden', visible > 0);
        });
    }

    // Visibilitas status sistem saat submit
    form.addEventListener('submit', function (e) {
        if (btn.disabled || !form.checkValidity()) { e.preventDefault(); return; }
        btn.disabled = true;
        spinner.classList.remove('hidden');
        arrow.classList.add('hidden');
        label.textContent = 'Loading...';
    });
})();
</script>

{{-- Buka lagi modal jika validasi gagal --}}
@if($errors->has('line_id'))
    <script>
        document.addEventListener('DOMContentLoaded', () => window.Modal?.open('line-select-modal'));
    </script>
@endif