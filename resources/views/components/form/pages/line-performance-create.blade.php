<div class="mb-6">
    <x-typography.heading eyebrow="Operations Input" title="New Performance Entry" />
    <x-card class="p-5">
        <form action="{{ route('line-performance.store') }}" method="POST">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3 items-end">
                <div class="flex-1 min-w-0">
                    <label for="line-performance-month" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Month</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <select id="line-performance-month" name="line-performance-month" class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition appearance-none">
                            <option value="">Choose month...</option>
                            @foreach (['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                                <option value="{{ $m }}" {{ old('line-performance-month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <label for="line-performance-year" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Year</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <select id="line-performance-year" name="line-performance-year" class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition appearance-none">
                            <option value="">Choose year...</option>
                            @for ($year = date('Y') - 1; $year <= date('Y') + 10; $year++)
                                <option value="{{ $year }}" {{ old('line-performance-year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <x-form.input name="line-performance-target" label="Target (%)" type="number" value="{{ old('line-performance-target') }}" placeholder="0.0" required min="0" max="100" step="0.1" class="w-full" />
                <x-form.input name="line-performance-actual" label="Actual (%)" type="number" value="{{ old('line-performance-actual') }}" placeholder="0.0" required min="0" max="100" step="0.1" class="w-full" />

                <div class="shrink-0 w-full sm:w-auto">
                    <x-button variant="success" type="submit" class="w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add
                    </x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>