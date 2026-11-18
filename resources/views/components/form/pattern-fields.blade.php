@props([
    'sensors',
    'pattern' => null,  {{-- null = form tambah --}}
    'prefix'  => 'pattern-create',
])

{{-- Field bersama untuk modal Tambah & Edit Pattern --}}
<div class="space-y-5">
    {{-- Name --}}
    <x-form.input
        id="{{ $prefix }}-name"
        name="name" label="Pattern Name"
        placeholder="e.g., 3MP"
        :value="$pattern?->name"
        :required="true" />

    {{-- Sensor Positions --}}
    <div>
        <p class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Sensor Positions</p>
        <p class="mb-3 text-xs text-gray-400">Centang sensor yang dipakai. Cycle adalah jumlah barang dalam satu pembacaan; durasi akan dibagi nilai Cycle.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach ($sensors as $sensor)
                @php
                    $active = $pattern?->sensors->firstWhere('id', $sensor->id);
                @endphp
                <div x-data="{ on: {{ $active ? 'true' : 'false' }} }"
                     class="flex items-center justify-between gap-3 p-3 rounded-xl border transition-colors"
                     :class="on ? 'border-sky-200 bg-sky-50/40' : 'border-gray-100 bg-white'">

                    {{-- Toggle aktif (tanpa name, tidak ikut dikirim) --}}
                    <label class="flex items-center gap-2.5 min-w-0 cursor-pointer select-none">
                        <input type="checkbox" x-model="on" class="w-4 h-4 rounded border-gray-300 text-sky-600 focus:ring-sky-400">
                        <span class="text-sm font-medium truncate" :class="on ? 'text-gray-800' : 'text-gray-400'" title="{{ $sensor->name }}">
                            {{ $sensor->name }}
                        </span>
                    </label>

                    <div class="flex items-end gap-2 shrink-0 transition-opacity" :class="on ? '' : 'opacity-40'">
                        <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                            Pos
                            <input type="number" name="sensors[{{ $sensor->id }}][pos]" value="{{ $active?->pivot->pos }}"
                                   min="1" placeholder="-" :disabled="!on" :required="on"
                                   class="mt-1 block w-16 h-9 text-sm text-center text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent disabled:cursor-not-allowed">
                        </label>
                        <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                            Cycle
                            <input type="number" name="sensors[{{ $sensor->id }}][cycle]" value="{{ $active?->pivot->cycle ?? 1 }}"
                                   min="1" title="Jumlah barang per pembacaan" :disabled="!on" :required="on"
                                   class="mt-1 block w-16 h-9 text-sm text-center text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent disabled:cursor-not-allowed">
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Timing (detik) --}}
    <div class="pt-4 border-t border-gray-100">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <x-form.input id="{{ $prefix }}-cycle-time" name="cycle_time" label="Target Cycle (s)" type="number" step="0.1" min="0"
                :value="$pattern?->cycle_time" :required="true" />
            <x-form.input id="{{ $prefix }}-min-time" name="min_time" label="Min / LCL (s)" type="number" step="0.1" min="0"
                :value="$pattern?->min_time" :required="true" />
            <x-form.input id="{{ $prefix }}-max-time" name="max_time" label="Max / UCL (s)" type="number" step="0.1" min="0"
                :value="$pattern?->max_time" :required="true" />
            <x-form.input id="{{ $prefix }}-except-time" name="except_time" label="Except Time (s)" type="number" step="0.1" min="0"
                :value="$pattern?->except_time ?? 0" :required="true"
                title="Data dengan durasi di bawah nilai ini dianggap sampah dan tidak ditampilkan" />
        </div>
        <p class="mt-2 text-xs text-gray-400">Except Time: data dengan durasi di bawah nilai ini tidak ditampilkan di chart (maksimal sama dengan Min / LCL).</p>
    </div>
</div>
