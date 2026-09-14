@props(['lines'])

<x-ui.modal id="line-select-modal" maxWidth="max-w-md">
    <div class="w-[380px] sm:w-[420px] bg-white rounded-2xl shadow-2xl border border-gray-100 p-6">
        <div class="mb-5">
            <h2 class="text-xl font-extrabold text-gray-800">Pilih Line Produksi</h2>
            <p class="mt-1 text-sm text-gray-500">Pilih line yang ingin Anda kelola. Data System Manager akan ditampilkan sesuai line ini.</p>
        </div>

        <form action="{{ route('line-selector.select') }}" method="POST" class="space-y-4">
            @csrf
            @error('line_id')
                <p class="text-sm text-red-600 bg-red-50 border border-red-200 rounded-xl px-3 py-2">{{ $message }}</p>
            @enderror

            <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
                @foreach($lines as $line)
                    <label for="line_{{ $line->id }}"
                        class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 cursor-pointer transition-all hover:border-red-300 hover:bg-red-50 has-[:checked]:border-red-500 has-[:checked]:bg-red-50 has-[:checked]:ring-2 has-[:checked]:ring-red-500/20">
                        <span class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white border border-gray-200 text-sm font-bold text-red-600">
                                {{ $loop->iteration }}
                            </span>
                            <span>
                                <span class="block text-sm font-semibold text-gray-800">{{ $line->name }}</span>
                                @if($line->businessUnit)
                                    <span class="block text-xs text-gray-400">{{ $line->businessUnit->name }}</span>
                                @endif
                            </span>
                        </span>
                        <input type="radio" name="line_id" id="line_{{ $line->id }}" value="{{ $line->id }}"
                            class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500/30" required>
                    </label>
                @endforeach
            </div>

            <button type="submit"
                class="w-full text-white bg-gradient-to-r from-red-600 to-rose-900 hover:from-red-700 hover:to-rose-950 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-full text-md px-5 py-3 text-center transform transition-all active:scale-[0.98] shadow-lg shadow-red-500/30">
                Masuk ke System Manager
            </button>
        </form>
    </div>
</x-ui.modal>
