<aside class="group fixed top-0 left-0 z-40 h-full w-14 hover:w-56 overflow-hidden bg-white border-r border-gray-100 shadow-sm transition-[width] duration-300 ease-in-out" aria-label="Sidebar">

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

    {{-- ===== SIDE BAR ===== --}}
    <nav class="px-2 pt-4 space-y-1">

        {{-- Home --}}
        <x-layout.sidebar.partials.link :href="route('system-managers.index')" :active="request()->is('/')" title="Home">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9"/>
            </x-slot:icon>
            Home
        </x-layout.sidebar.partials.link>

        <hr class="my-2 border-gray-200">

        {{-- Best Record --}}
        <x-layout.sidebar.partials.link :href="route('best-records.index')" :active="request()->routeIs('best-records.*')" title="Best Record">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v5m0 0H9m3 0h3M8 10H5a2 2 0 01-2-2V5h5m0 5h8m0 0h3a2 2 0 002-2V5h-3m-8 5V5h8v5"/>
            </x-slot:icon>
            Best Record
        </x-layout.sidebar.partials.link>

        {{-- Cycle Time --}}
        <x-layout.sidebar.partials.dropdown label="Cycle Time" :active="request()->routeIs('cycletimes.*')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </x-slot:icon>
            <x-layout.sidebar.partials.sublink :href="route('cycletimes.monitoring.index')" :active="request()->routeIs('cycletimes.monitoring.*')">Monitoring</x-layout.sidebar.partials.sublink>
            <x-layout.sidebar.partials.sublink :href="route('cycletimes.setting.index')" :active="request()->routeIs('cycletimes.setting.*')">Setting</x-layout.sidebar.partials.sublink>
        </x-layout.sidebar.partials.dropdown>

        {{-- Documents --}}
        <x-layout.sidebar.partials.dropdown label="Documents" :active="request()->routeIs('dasgs.*', 'sops.*', 'risk-assessments.*')">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </x-slot:icon>
            <x-layout.sidebar.partials.sublink :href="route('dasgs.index')" :active="request()->routeIs('dasgs.*')">DASg</x-layout.sidebar.partials.sublink>
            <x-layout.sidebar.partials.sublink :href="route('sops.index')" :active="request()->routeIs('sops.*')">SOP</x-layout.sidebar.partials.sublink>
            <x-layout.sidebar.partials.sublink :href="route('risk-assessments.index')" :active="request()->routeIs('risk-assessments.*')">Risk Assessment</x-layout.sidebar.partials.sublink>
        </x-layout.sidebar.partials.dropdown>

        {{-- Line Performance --}}
        <x-layout.sidebar.partials.link :href="route('line-performance.index')" :active="request()->routeIs('line-performance.*')" title="Line Performance">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </x-slot:icon>
            Line Performance
        </x-layout.sidebar.partials.link>

        {{-- Machine --}}
        <x-layout.sidebar.partials.link :href="route('machines.index')" :active="request()->routeIs('machines.*')" title="Machine">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </x-slot:icon>
            Machine
        </x-layout.sidebar.partials.link>

        {{-- Production --}}
        <x-layout.sidebar.partials.link :href="route('products.index')" :active="request()->routeIs('products.*')" title="Production">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 013-3h0a3 3 0 013 3v4m3-2l.917 11.923A1 1 0 0117.92 21H6.08a1 1 0 01-.997-1.077L6 8h12z"/>
            </x-slot:icon>
            Production
        </x-layout.sidebar.partials.link>

        <hr class="my-2 border-rose-400">

        @if(auth()->user()?->role === 'admin')
            <x-layout.sidebar.partials.link :href="route('users.index')" :active="request()->is('users*')" title="User">
                <x-slot:icon>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </x-slot:icon>
                User
            </x-layout.sidebar.partials.link>
        @endif

        
    </nav>

    {{-- Back (bottom) --}}
    <div class="absolute bottom-4 left-0 right-0 px-2">
        <x-layout.sidebar.partials.link :href="route('dashboards.index')" title="Back to Dashboard" class="w-full">
            <x-slot:icon>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </x-slot:icon>
            Back
        </x-layout.sidebar.partials.link>
    </div>
</aside>