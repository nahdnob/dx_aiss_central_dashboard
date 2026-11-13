@props([
    'modalId',
    'prefix',
    'variant'     => 'stacked', {{-- stacked | inline --}}
    'submitLabel' => 'Continue',
    'cancelLabel' => 'Cancel',
    'disabled'    => false,
])

@if($variant === 'inline')
    <div class="flex justify-end gap-2 border-t border-gray-200 pt-2">
        <button type="button" data-modal-close="{{ $modalId }}"
            class="rounded-full px-5 py-2 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
            {{ $cancelLabel }}
        </button>
        <button type="submit" id="{{ $prefix }}-submit-btn" @disabled($disabled)
            class="rounded-full bg-gradient-to-r from-red-600 to-rose-900 px-5 py-2 text-sm font-bold text-white shadow-lg shadow-red-500/30 transition-all hover:from-red-700 hover:to-rose-950 focus:outline-none focus:ring-4 focus:ring-red-300 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none">
            {{ $submitLabel }}
        </button>
    </div>
@else
    <div class="space-y-2 border-t border-gray-200 pt-1">
        <button type="submit" id="{{ $prefix }}-submit-btn" @disabled($disabled)
            class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-red-600 to-rose-900 px-5 py-3 text-base font-bold text-white shadow-lg shadow-red-500/30 transition-all hover:from-red-700 hover:to-rose-950 focus:outline-none focus:ring-4 focus:ring-red-300 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none">
            <svg id="{{ $prefix }}-spinner" class="hidden h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span id="{{ $prefix }}-submit-label">{{ $submitLabel }}</span>
            <svg id="{{ $prefix }}-arrow" class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m0 0-5-5m5 5-5 5"/>
            </svg>
        </button>

        <button type="button" onclick="window.Modal?.close('{{ $modalId }}')"
            class="w-full rounded-full px-5 py-2 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
            {{ $cancelLabel }}
        </button>
    </div>

    @if(!$slot->isEmpty())
        <p class="mt-4 text-center text-[11px] text-gray-400">{{ $slot }}</p>
    @endif
@endif