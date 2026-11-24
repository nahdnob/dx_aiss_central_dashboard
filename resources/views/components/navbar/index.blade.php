<nav class="relative z-50 bg-gradient-to-r from-sky-200 from-20% via-red-600 via-60% to-rose-900" x-data="{ isOpen: false }">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="flex h-16 items-center justify-between">
			<div class="flex items-center">
				<div class="flex-shrink-0">
					<img class="w-36" src="{{asset('img/denso_logo.png')}}" alt="Company">
				</div>
				<div class="hidden md:block">
					<div class="ml-10 flex items-baseline space-x-4">
					<!-- <x-navbar.link href="/" :active="request()->is('/')">Monitoring</x-navbar.link> -->
					<!-- <x-navbar.link href="/schedule" :active="request()->is('schedule')">Monitoring</x-navbar.link> -->
					</div>
				</div>
			</div>
			<div class="hidden md:block">
				<div class="flex flex-row">
					<div class="ml-4 flex items-center md:ml-6">
						<!-- Clock -->
						<div class="text-right text-white px-4 flex flex-col">
							<p id="current-time" class="text-3xl font-mono tracking-wide">00:00:00</p>
							<p id="current-date" class="text-base font-mono tracking-wide">dd/mm/yyyy</p>
						</div>
						<!-- Profile dropdown -->
						<div class="relative ml-3" x-data="{ isOpen: false }">
							<div>
								<button type="button" @click="isOpen = !isOpen" @click.away="isOpen = false" class="relative flex max-w-xs items-center rounded-full bg-red-700 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
									<span class="absolute -inset-1.5"></span>
									<span class="sr-only">Open user menu</span>
									@auth
										<img class="h-14 w-14 rounded-full"
											src="{{ Auth::user()->image 
												? asset('storage/' . Auth::user()->image) 
												: asset('assets/images/profile-blank.jpg')
											}}"
											alt="{{ Auth::user()->name }}"
										>
									@else
										<img class="h-14 w-14 rounded-full"
											src="{{asset('assets/images/profile-blank.jpg')}}"
											alt="Guest">
									@endauth
								</button>
							</div>
							<div x-show="isOpen"
								x-transition:enter="transition ease-out duration-100 transform"
								x-transition:enter-start="opacity-0 scale-95"
								x-transition:enter-end="opacity-100 scale-100"
								x-transition:leave="transition ease-in duration-75 transform"
								x-transition:leave-start="opacity-100 scale-100"
								x-transition:leave-end="opacity-0 scale-95"
								class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
								
								@auth
									<a href="javascript:void(0)" data-modal-open="profile-modal" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Your Profile</a>
									<a href="{{ route('dashboards.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Settings</a>
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
									<a href="javascript:void(0)" onclick="Toast.show('Peringatan: Anda perlu Sign In terlebih dahulu!', 'error')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Your Profile</a>
									<a href="javascript:void(0)" onclick="Toast.show('Peringatan: Anda perlu Sign In terlebih dahulu!', 'error')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Settings</a>
									<a href="javascript:void(0)" data-modal-open="login-modal" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-100 mt-1 pt-2" role="menuitem" tabindex="-1">Sign in</a>
								@endauth
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="-mr-2 flex md:hidden">
				<!-- Mobile menu button -->
				<button type="button" @click="isOpen = !isOpen" class="relative inline-flex items-center justify-center rounded-md bg-red-700 p-2 text-gray-400 hover:bg-red-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
					<span class="absolute -inset-0.5"></span>
					<span class="sr-only">Open main menu</span>
					<svg :class="{'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
					</svg>
					<!-- Menu open: "block", Menu closed: "hidden" -->
					<svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
		</div>
	</div>
	<div x-show="isOpen" class="md:hidden" id="mobile-menu">
		<!-- <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3"> -->
				<!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
				<!-- <a href="#" class="block rounded-md bg-red-700 px-3 py-2 text-base font-medium text-white" aria-current="page">Monitoring</a> -->
				<!-- <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Schedule</a> -->
		<!-- </div> -->
		<div class="border-t border-gray-700 pb-3 pt-4">
			<div class="flex items-center px-5">
				<div class="flex-shrink-0">
					<img class="h-10 w-10 rounded-full" src="{{asset('img/Fachmi.jpg')}}" alt="You">
				</div>
				<div class="ml-3">
					<div class="text-base font-medium leading-none text-white">Tom Cook</div>
					<div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
				</div>
			</div>
			<div class="mt-3 space-y-1 px-2">
				<a href="#" class="block rounded-md px-16 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your Profile</a>
				<a href="#" class="block rounded-md px-16 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Settings</a>
				<a href="#" class="block rounded-md px-16 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign out</a>
			</div>
		</div>
	</div>
</nav>