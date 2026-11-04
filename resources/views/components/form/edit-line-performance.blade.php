<div class="relative bg-white rounded-3xl p-8 shadow-2xl overflow-hidden max-w-lg w-full border border-gray-100 mx-auto">

    {{-- Top accent gradient --}}
    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-red-500 via-rose-600 to-red-800"></div>

    {{-- Decorative background blur --}}
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70 pointer-events-none"></div>

    {{-- Header --}}
    <div class="relative flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center shrink-0 border border-red-200/50 shadow-inner">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Edit Line Performance</h2>
            <p class="text-sm font-medium text-gray-400 mt-0.5 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                ID: LP-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
            </p>
        </div>
    </div>

    <form action="{{ route('line-performance.update', $item->id) }}" method="POST" class="relative space-y-5">
        @csrf
        @method('PUT')

        {{-- Month & Year side by side --}}
        <div class="grid grid-cols-2 gap-4">
            {{-- Month --}}
            <div class="mb-3">
                <label for="month-{{ $item->id }}" class="block text-[11px] font-extrabold tracking-widest text-gray-500 uppercase mb-2 ml-1">
                    Month
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <select name="month" id="month-{{ $item->id }}"
                        class="block w-full pl-10 pr-4 py-3.5 text-sm text-gray-700 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200 hover:bg-gray-50 appearance-none">
                        @foreach (['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                            <option value="{{ $m }}" {{ $item->month == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Year --}}
            <div class="mb-3">
                <label for="year-{{ $item->id }}" class="block text-[11px] font-extrabold tracking-widest text-gray-500 uppercase mb-2 ml-1">
                    Year
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <select name="year" id="year-{{ $item->id }}"
                        class="block w-full pl-10 pr-4 py-3.5 text-sm text-gray-700 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200 hover:bg-gray-50 appearance-none">
                        @for ($year = date('Y') - 1; $year <= date('Y') + 10; $year++)
                            <option value="{{ $year }}" {{ $item->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        {{-- Target --}}
        <div class="mb-3">
            <label for="target-{{ $item->id }}" class="block text-[11px] font-extrabold tracking-widest text-gray-500 uppercase mb-2 ml-1">
                Target (%)
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <input
                    type="number"
                    name="target"
                    id="target-{{ $item->id }}"
                    value="{{ old('target', $item->target) }}"
                    placeholder="0.0"
                    step="0.1" min="0" max="100" required
                    class="block w-full pl-10 pr-4 py-3.5 text-sm text-gray-700 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200 hover:bg-gray-50"
                >
            </div>
        </div>

        {{-- Actual --}}
        <div class="mb-3">
            <label for="actual-{{ $item->id }}" class="block text-[11px] font-extrabold tracking-widest text-gray-500 uppercase mb-2 ml-1">
                Actual (%)
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <input
                    type="number"
                    name="actual"
                    id="actual-{{ $item->id }}"
                    value="{{ old('actual', $item->actual) }}"
                    placeholder="0.0"
                    step="0.1" min="0" max="100" required
                    class="block w-full pl-10 pr-4 py-3.5 text-sm text-gray-700 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200 hover:bg-gray-50"
                >
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-6 mt-2 border-t border-gray-100">
            <button
                type="button"
                data-modal-close="edit-line-performance-modal-{{ $item->id }}"
                class="px-5 py-2.5 text-sm font-bold text-gray-500 bg-transparent hover:bg-gray-100 rounded-xl transition-colors duration-200"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white
                       bg-gradient-to-r from-red-600 to-rose-700 hover:brightness-110
                       rounded-xl shadow-lg shadow-red-500/30 transition-all duration-200 transform hover:-translate-y-0.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                          d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>