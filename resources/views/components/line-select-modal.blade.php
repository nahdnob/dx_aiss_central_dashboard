@props(['lines'])

<x-ui.modal id="line-select-modal" maxWidth="max-w-md">
    <div class="w-[380px] sm:w-[420px] bg-white rounded-2xl shadow-2xl border border-gray-100 p-6">
        <!-- Tittle -->
        <div class="mb-5">
            <h2 class="text-xl font-extrabold text-gray-800">Choose your destination</h2>
            <p class="mt-1 text-sm text-gray-500">Where do you wanna go?</p>
        </div>

        <form action="{{ route('line-selector.select') }}" method="POST" class="space-y-4">
            @csrf
            @error('line_id')
                <p class="text-sm text-red-600 bg-red-50 border border-red-200 rounded-xl px-3 py-2">{{ $message }}</p>
            @enderror

            <div class="grid grid-cols-2 gap-4 max-h-64 overflow-y-auto pr-1">
                @foreach($lines as $line)
                    <label for="line_{{ $line->id }}"
                        class="relative flex flex-col gap-3 rounded-2xl bg-gray-50 p-4 cursor-pointer transition-all duration-200 border-2 border-transparent hover:bg-gray-100 has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                        
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                            </svg>
                        </span>

                        <span class="min-w-0">
                            <span class="block text-sm font-bold text-gray-800 truncate">{{ $line->name }}</span>
                            @if($line->businessUnit)
                                <span class="block text-xs text-gray-400 truncate mt-0.5">{{ $line->businessUnit->name }}</span>
                            @endif
                        </span>

                        <input type="radio" name="line_id" id="line_{{ $line->id }}" value="{{ $line->id }}"
                            class="absolute top-3 right-3 h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500/30" required>
                    </label>
                @endforeach
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-2 text-white bg-gradient-to-r from-red-600 to-rose-900 hover:from-red-700 hover:to-rose-950 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-full text-md px-5 py-3 text-center transform transition-all active:scale-[0.98] shadow-lg shadow-red-500/30">
                Go
                <svg class="w-6 h-6 text-white aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                </svg>
            </button>

        </form>
    </div>
</x-ui.modal>
