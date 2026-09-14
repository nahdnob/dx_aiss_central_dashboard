{{-- resources/views/components/ui/sidebar.blade.php --}}

<aside class="group fixed top-0 left-0 z-40 h-full w-14 hover:w-56 overflow-hidden bg-white border-r border-gray-100 shadow-sm transition-[width] duration-300 ease-in-out"
       aria-label="Sidebar">

    {{-- Logo area --}}
    <div class="flex items-center justify-center h-14 border-b border-gray-100">
        <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V9l-6-6z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v6h6"/>
        </svg>
        <span class="ml-2 text-sm font-bold text-gray-800 tracking-wide opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">
            DENSO
        </span>
    </div>

    <nav class="px-2 pt-4 space-y-1">
        {{-- Home --}}
        <a href="{{ route('system-managers.index') }}"
           class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer {{ request()->is('/') ? 'bg-red-500/10 text-red-600 border-l-[3px] border-red-600 pl-[7px]' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}"
           title="Home">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9"/>
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Home</span>
        </a>

        {{-- Best Record --}}
        <a href="{{ route('best-records.index') }}"
           class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer {{ request()->routeIs('best-records.*') ? 'bg-red-500/10 text-red-600 border-l-[3px] border-red-600 pl-[7px]' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}"
           title="Best Record">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v5m0 0H9m3 0h3M8 10H5a2 2 0 01-2-2V5h5m0 5h8m0 0h3a2 2 0 002-2V5h-3m-8 5V5h8v5"/>
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Best Record</span>
        </a>

        {{-- Line Performance --}}
        <a href="{{ route('line-performance.index') }}"
           class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer {{ request()->routeIs('line-performance.*') ? 'bg-red-500/10 text-red-600 border-l-[3px] border-red-600 pl-[7px]' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}"
           title="Line Performance">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Line Performance</span>
        </a>

        {{-- Production --}}
        <a href="{{ route('products.index') }}"
           class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer {{ request()->routeIs('products.*') ? 'bg-red-500/10 text-red-600 border-l-[3px] border-red-600 pl-[7px]' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}"
           title="Production">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 013-3h0a3 3 0 013 3v4m3-2l.917 11.923A1 1 0 0117.92 21H6.08a1 1 0 01-.997-1.077L6 8h12z"/>
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Production</span>
        </a>

        {{-- Cycle Time (Dropdown) --}}
        @php $isCycleTimeActive = request()->routeIs('cycletimes.*'); @endphp
        <div x-data="{ open: {{ $isCycleTimeActive ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer w-full justify-between {{ $isCycleTimeActive ? 'text-red-600 font-bold' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Cycle Time</span>
                </div>
                <svg class="w-4 h-4 flex-shrink-0 ml-2 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                     :class="{ 'rotate-180': open }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-collapse
                 class="flex flex-col ml-9 mt-1 space-y-1 opacity-0 overflow-hidden transition-opacity duration-200 group-hover:opacity-100">
                <a href="{{ route('cycletimes.monitoring.index') }}"
                   class="text-sm py-1.5 px-3 rounded-lg transition-colors duration-150 {{ request()->routeIs('cycletimes.monitoring.*') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-500 hover:text-red-500 hover:bg-gray-50' }}">
                    Monitoring
                </a>
                <a href="{{ route('cycletimes.setting.index') }}"
                   class="text-sm py-1.5 px-3 rounded-lg transition-colors duration-150 {{ request()->routeIs('cycletimes.setting.*') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-500 hover:text-red-500 hover:bg-gray-50' }}">
                    Setting
                </a>
            </div>
        </div>

        <hr class="my-2 border-gray-100">

        {{-- User --}}
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer {{ request()->is('users*') ? 'bg-red-500/10 text-red-600 border-l-[3px] border-red-600 pl-[7px]' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}"
           title="User">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">User</span>
        </a>

        {{-- Machine --}}
        <a href="{{ route('machines.index') }}"
           class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer {{ request()->routeIs('machines.*') ? 'bg-red-500/10 text-red-600 border-l-[3px] border-red-600 pl-[7px]' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}"
           title="Machine">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Machine</span>
        </a>

        {{-- Documents (Dropdown) --}}
        @php $isDocumentsActive = request()->routeIs('documents.*'); @endphp
        <div x-data="{ open: {{ $isDocumentsActive ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer w-full justify-between {{ $isDocumentsActive ? 'text-red-600 font-bold' : 'text-gray-500 hover:bg-red-500/[0.08] hover:text-red-600' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Documents</span>
                </div>
                <svg class="w-4 h-4 flex-shrink-0 ml-2 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
                     :class="{ 'rotate-180': open }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-collapse
                 class="flex flex-col ml-9 mt-1 space-y-1 opacity-0 overflow-hidden transition-opacity duration-200 group-hover:opacity-100">
                <a href="{{ route('documents.dasg') }}"
                   class="text-sm py-1.5 px-3 rounded-lg transition-colors duration-150 {{ request()->routeIs('documents.dasg') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-500 hover:text-red-500 hover:bg-gray-50' }}">
                    DASg
                </a>
                <a href="{{ route('documents.sop') }}"
                   class="text-sm py-1.5 px-3 rounded-lg transition-colors duration-150 {{ request()->routeIs('documents.sop') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-500 hover:text-red-500 hover:bg-gray-50' }}">
                    SOP
                </a>
                <a href="{{ route('documents.risk-assessment') }}"
                   class="text-sm py-1.5 px-3 rounded-lg transition-colors duration-150 {{ request()->routeIs('documents.risk-assessment') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-500 hover:text-red-500 hover:bg-gray-50' }}">
                    Risk Assessment
                </a>
            </div>
        </div>
    </nav>

    {{-- Back (bottom) --}}
    <div class="absolute bottom-4 left-0 right-0 px-2">
        <a href="{{ route('dashboards.index') }}"
           class="flex items-center gap-3 px-2.5 py-2 rounded-[10px] transition-colors duration-150 cursor-pointer w-full text-gray-400 hover:text-red-500 hover:bg-red-50"
           title="Back to Dashboard">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm font-semibold opacity-0 w-0 overflow-hidden whitespace-nowrap transition-all duration-200 group-hover:opacity-100 group-hover:w-auto">Back</span>
        </a>
    </div>
</aside>