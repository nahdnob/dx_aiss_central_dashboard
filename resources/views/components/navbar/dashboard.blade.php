<nav class="fixed top-0 z-50 w-full bg-gradient-to-r from-sky-200 from-20% via-red-600 via-60% to-rose-900 border-b border-default">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar" aria-controls="top-bar-sidebar" type="button" class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
                    </svg>
                </button>
                <div class="flex items-center h-6 ms-2 md:me-24 overflow-hidden">
                    <img src="{{asset('img/denso_logo.png')}}" class="h-24 object-contain"/>
                </div>
            </div>
            <div class="flex items-center">
                @auth
                    {{-- Line aktif; klik untuk ganti line --}}
                    <button type="button" data-modal-open="line-select-modal" title="Ganti Line"
                        class="flex items-center gap-2 rounded-full bg-white/15 hover:bg-white/25 border border-white/30 px-3 py-1.5 text-xs font-bold text-white uppercase tracking-wide transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        <span class="max-w-[10rem] truncate">{{ session('selected_line_name', 'Select Line') }}</span>
                    </button>
                @endauth
                <div class="relative flex items-center ms-3" x-data="{ openProfile: false }">
                    <div>
                        <button type="button" @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false">
                            <span class="sr-only">Open user menu</span>
                            @auth
                                <img class="w-8 h-8 rounded-full object-cover"
                                    src="{{ Auth::user()->image 
                                        ? asset('storage/' . Auth::user()->image) 
                                        : asset('assets/images/profile-blank.jpg')
                                    }}"
                                    alt="{{ Auth::user()->name }}"
                                >
                            @else
                                <img class="w-8 h-8 rounded-full object-cover"
                                    src="{{asset('assets/images/profile-blank.jpg')}}"
                                    alt="Guest">
                            @endauth
                        </button>
                    </div>
                    
                    <div x-show="openProfile"
                        x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-10 mt-2 z-50 w-48 bg-white border border-gray-200 rounded-md shadow-lg focus:outline-none" style="display: none;">
                        
                        @auth
                            <a href="javascript:void(0)" data-modal-open="profile-modal"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                            <a href="{{ route('dashboards.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                            <a href="javascript:void(0)" data-modal-open="line-select-modal"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Ganti Line</a>
                            <div class="px-4 py-2 text-sm text-gray-700 border-t border-gray-200 mt-1 pt-2">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="px-4 py-2 text-xs text-gray-500">
                                NPK: {{ Auth::user()->npk ?? '-' }}
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Sign Out
                                </button>
                            </form>
                        @else
                            <a href="javascript:void(0)" onclick="Toast.show('Peringatan: Anda perlu Sign In terlebih dahulu!', 'error')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                            <a href="javascript:void(0)" onclick="Toast.show('Peringatan: Anda perlu Sign In terlebih dahulu!', 'error')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                            <a href="javascript:void(0)" data-modal-open="login-modal"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-100 mt-1 pt-2 font-semibold" role="menuitem">Sign in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- Modal pilih / ganti line (dipakai tombol line di navbar & tombol "Select Line" di dashboard) --}}
@auth
    <x-modal.pages.line-select :lines="\App\Models\Line::with('businessUnit')->orderBy('name')->get()" />
@endauth