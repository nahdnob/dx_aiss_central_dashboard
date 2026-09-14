<div class="flex w-full min-h-[480px] max-w-3xl mx-auto rounded-[28px] overflow-hidden shadow-2xl">
    {{-- Left Panel: DENSO Welcome --}}
    <div class="relative hidden sm:flex w-5/12 flex-col justify-between overflow-hidden p-7"
         style="background: url('{{ asset('assets/images/denso-background.png') }}') center center / cover no-repeat; background-color: white;">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-white/70 via-white/60 to-white/85"></div>

        {{-- DENSO Logo --}}
        <div class="relative z-10">
            <img src="{{ asset('img/denso_logo.png') }}"
                 class="h-14 w-auto object-contain" alt="DENSO">
        </div>

        {{-- Welcome Text --}}
        <div class="relative z-10 my-8 max-w-[15rem]">
            <h2 class="text-2xl font-extrabold leading-tight text-gray-800">
                Welcome <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-rose-900">Back!</span>
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-gray-500">
                Sign in to access the AISS Central Dashboard and monitor your production line in real time.
            </p>
        </div>

        {{-- Footer --}}
        <div class="relative z-10">
            <p class="text-[9px] text-gray-400 tracking-wide">
                © {{ date('Y') }} DENSO CORPORATION
            </p>
        </div>
    </div>

    {{-- Right Panel: Login Form --}}
    <div class="flex-1 bg-white flex items-center justify-center px-8 sm:px-10 py-10">
        <form id="login-form" method="POST" action="{{ route('login') }}" class="w-full max-w-sm space-y-5">
            @csrf
            {{-- Header --}}
            <div class="pb-1">
                <h1 class="text-2xl font-extrabold text-gray-800">
                    Sign In
                </h1>
                <p class="text-sm text-gray-400 mt-1">Enter your NPK and password to continue</p>
            </div>
            {{-- NPK --}}
            <div>
                <label for="npk" class="block mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">NPK</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="npk" id="npk"
                        class="bg-gray-50 border border-gray-200 text-gray-900 rounded-full focus:ring-2 focus:ring-red-500/30 focus:border-red-500 block w-full pl-11 p-3.5 transition-all duration-200 placeholder-zinc-300 font-medium"
                        placeholder="219XXXX" required>
                </div>
            </div>
            {{-- Password --}}
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" id="password"
                        class="bg-gray-50 border border-gray-200 text-gray-900 rounded-full focus:ring-2 focus:ring-red-500/30 focus:border-red-500 block w-full pl-11 p-3.5 transition-all duration-200 placeholder-zinc-300 font-medium tracking-widest"
                        placeholder="••••••••" required>
                </div>
            </div>
            {{-- Remember me --}}
            <div class="flex items-center">
                <label for="remember" class="flex items-center gap-2 text-sm text-gray-500 select-none cursor-pointer">
                    <input type="checkbox" name="remember" id="remember"
                        class="rounded border-gray-300 text-red-600 focus:ring-red-500/30">
                    Remember me
                </label>
            </div>
            {{-- Submit --}}
            <button type="submit" id="login-submit-btn"
                class="w-full text-white bg-gradient-to-r from-red-600 to-rose-900 hover:from-red-700 hover:to-rose-950 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-full text-md px-5 py-3.5 text-center transform transition-all active:scale-[0.98] shadow-lg shadow-red-500/30 disabled:opacity-60 disabled:cursor-not-allowed">
                <span id="login-submit-label">Sign In</span>
            </button>
        </form>
    </div>
</div>

<script>
    (function () {
        const form = document.getElementById('login-form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = document.getElementById('login-submit-btn');
            const label = document.getElementById('login-submit-label');
            const originalLabel = label.textContent;
            btn.disabled = true;
            label.textContent = 'Signing in...';

            fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: new FormData(form),
            })
                .then(async (res) => {
                    const data = await res.json().catch(() => ({}));

                    if (res.ok && data.success) {
                        // The session (and its CSRF token) was regenerated on login, so any
                        // forms already rendered on this page (e.g. the line-select modal)
                        // are carrying a now-stale _token — refresh them before they're used.
                        if (data.csrf_token) {
                            document.querySelectorAll('input[name="_token"]').forEach((input) => {
                                input.value = data.csrf_token;
                            });
                        }

                        if (document.getElementById('line-select-modal')) {
                            window.Modal?.open('line-select-modal');
                        } else {
                            window.location.href = '{{ route('dashboards.index') }}';
                        }
                        return;
                    }

                    const message = data.message
                        || (data.errors && Object.values(data.errors)[0]?.[0])
                        || 'NPK atau password salah';
                    window.Toast?.fire(message, 'error');
                })
                .catch(function () {
                    window.Toast?.fire('Terjadi kesalahan, silakan coba lagi.', 'error');
                })
                .finally(function () {
                    btn.disabled = false;
                    label.textContent = originalLabel;
                });
        });
    })();
</script>
