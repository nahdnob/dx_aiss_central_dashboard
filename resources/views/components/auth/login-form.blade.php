<form method="POST" action="{{ route('login') }}" class="w-full space-y-5" novalidate>
    @csrf

    <div class="pb-1">
        <p class="text-sm font-semibold text-slate-400 uppercase">AISS Central Dashboard</p>
        <h1 class="text-3xl font-extrabold text-slate-700 mb-4">Welcome Back!</h1>
        <p class="text-sm text-gray-500">Please enter your details</p>
    </div>

    <div>
        <label for="npk" class="block mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">NPK</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <input type="text" name="npk" id="npk" placeholder="e.g. 219XXXX" class="bg-gray-50 border border-gray-200 text-gray-900 rounded-full focus:ring-2 focus:ring-red-500/30 focus:border-red-500 block w-full pl-11 p-3.5 transition-all duration-200 placeholder-gray-400 font-medium" autocomplete="username" autocapitalize="off" spellcheck="false" autofocus required>
        </div>
    </div>

    <div>
        <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Password</label>
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <input type="password" name="password" id="password" placeholder="Enter your password" class="bg-gray-50 border border-gray-200 text-gray-900 rounded-full focus:ring-2 focus:ring-red-500/30 focus:border-red-500 block w-full pl-11 pr-12 p-3.5 transition-all duration-200 placeholder-gray-400 font-medium" autocomplete="current-password" required>
        </div>
    </div>

    <button type="submit" class="w-full text-white bg-gradient-to-r from-red-600 to-rose-900 hover:from-red-700 hover:to-rose-950 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-full text-base px-5 py-3.5 text-center transform transition-all active:scale-[0.98] shadow-lg shadow-red-500/30 disabled:opacity-60 disabled:cursor-not-allowed">
        Sign In
    </button>

    <p class="text-xs text-gray-400 text-center">
        Forgot your password or can't sign in? Contact your system administrator.
    </p>
</form>
