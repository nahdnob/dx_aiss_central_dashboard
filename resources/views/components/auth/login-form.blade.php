<div class="flex w-full min-h-[480px] max-w-3xl mx-auto rounded-[28px] overflow-hidden shadow-2xl">
    {{-- Left Panel --}}
    <div class="relative hidden sm:flex w-5/12 flex-col justify-between overflow-hidden p-7"
        style="background: url('{{ asset('assets/images/denso-background.png') }}') center center / cover no-repeat; background-color: white;">
        <div class="relative z-10">
            <img src="{{ asset('img/denso_logo.png') }}" class="h-20 w-auto object-contain" alt="DENSO">
        </div>
        <div class="relative z-10">
            <p class="text-xs text-gray-400 tracking-wide">© {{ date('Y') }} DENSO CORPORATION</p>
        </div>
    </div>

    {{-- Right Panel --}}
    <div class="flex-1 bg-white flex items-center justify-center px-8 sm:px-10 py-10">
        <form id="login-form" method="POST" action="{{ route('login') }}" class="w-full max-w-sm space-y-5" novalidate>
            @csrf

            {{-- Logo (mobile only) --}}
            <img src="{{ asset('img/denso_logo.png') }}" class="h-12 w-auto object-contain sm:hidden" alt="DENSO">

            {{-- Header --}}
            <div class="pb-1">
                <p class="text-sm font-semibold text-slate-400 uppercase">AISS Central Dashboard</p>
                <h1 class="text-3xl font-extrabold text-slate-700 mb-4">Welcome Back!</h1>
                <p class="text-sm text-gray-500">Please enter your details</p>
            </div>

            {{-- Inline error --}}
            <div id="login-error" class="hidden items-start gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                 role="alert" aria-live="assertive">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="login-error-text"></span>
            </div>

            {{-- NPK --}}
            <div>
                <label for="npk" class="block mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">NPK</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input class="bg-gray-50 border border-gray-200 text-gray-900 rounded-full focus:ring-2 focus:ring-red-500/30 focus:border-red-500 block w-full pl-11 p-3.5 transition-all duration-200 placeholder-gray-400 font-medium"
                        type="text" name="npk" id="npk" placeholder="e.g. 219XXXX"
                        autocomplete="username" autocapitalize="off" spellcheck="false" autofocus required>
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input class="bg-gray-50 border border-gray-200 text-gray-900 rounded-full focus:ring-2 focus:ring-red-500/30 focus:border-red-500 block w-full pl-11 pr-12 p-3.5 transition-all duration-200 placeholder-gray-400 font-medium"
                        type="password" name="password" id="password" placeholder="Enter your password"
                        autocomplete="current-password" required>
                    <button type="button" id="toggle-password"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-red-500"
                        aria-label="Show password" aria-pressed="false">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <p id="caps-warning" class="hidden mt-1.5 text-xs text-amber-600">Caps Lock is on.</p>
            </div>

            {{-- Submit --}}
            <button type="submit" id="login-submit-btn"
                class="w-full text-white bg-gradient-to-r from-red-600 to-rose-900 hover:from-red-700 hover:to-rose-950 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-full text-base px-5 py-3.5 text-center transform transition-all active:scale-[0.98] shadow-lg shadow-red-500/30 disabled:opacity-60 disabled:cursor-not-allowed">
                <span id="login-submit-label">Sign In</span>
            </button>

            {{-- Help --}}
            <p class="text-xs text-gray-400 text-center">
                Forgot your password or can't sign in? Contact your system administrator.
            </p>
        </form>
    </div>
</div>
<script>
(function () {
    const form = document.getElementById('login-form');
    if (!form) return;

    const btn      = document.getElementById('login-submit-btn');
    const label    = document.getElementById('login-submit-label');
    const errBox   = document.getElementById('login-error');
    const errText  = document.getElementById('login-error-text');
    const npk      = document.getElementById('npk');
    const pwd      = document.getElementById('password');
    const toggle   = document.getElementById('toggle-password');
    const caps     = document.getElementById('caps-warning');

    const showError = msg => {
        errText.textContent = msg;
        errBox.classList.remove('hidden');
        errBox.classList.add('flex');
    };
    const hideError = () => {
        errBox.classList.add('hidden');
        errBox.classList.remove('flex');
    };

    // Show / hide password
    toggle.addEventListener('click', () => {
        const show = pwd.type === 'password';
        pwd.type = show ? 'text' : 'password';
        toggle.setAttribute('aria-pressed', String(show));
        toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });

    // Caps Lock warning
    pwd.addEventListener('keyup', e => {
        caps.classList.toggle('hidden', !e.getModifierState('CapsLock'));
    });
    pwd.addEventListener('blur', () => caps.classList.add('hidden'));

    // Clear error when the user types again
    [npk, pwd].forEach(el => el.addEventListener('input', hideError));

    form.addEventListener('submit', async e => {
        e.preventDefault();
        if (btn.disabled) return;

        if (!npk.value.trim()) { showError('Please enter your NPK.'); npk.focus(); return; }
        if (!pwd.value)        { showError('Please enter your password.'); pwd.focus(); return; }

        hideError();
        btn.disabled = true;
        label.textContent = 'Signing in...';
        let succeeded = false;

        try {
            const res  = await fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: new FormData(form),
            });
            const data = await res.json().catch(() => ({}));

            if (res.ok && data.success) {
                succeeded = true;
                if (document.getElementById('line-select-modal')) {
                    window.Modal?.open('line-select-modal');
                } else {
                    window.location.href = '{{ route('dashboards.index') }}';
                }
                return;
            }

            let msg;
            if (res.status === 419)      msg = 'Your session has expired. Please refresh the page and try again.';
            else if (res.status === 429) msg = 'Too many attempts. Please wait a moment and try again.';
            else if (res.status >= 500)  msg = 'Server error. Please try again or contact the administrator.';
            else msg = data.message
                    || (data.errors && Object.values(data.errors)[0]?.[0])
                    || 'Incorrect NPK or password.';

            showError(msg);
            pwd.value = '';
            pwd.focus();
        } catch (err) {
            showError('Cannot reach the server. Check your connection and try again.');
        } finally {
            if (!succeeded) {
                btn.disabled = false;
                label.textContent = 'Sign In';
            }
        }
    });
})();
</script>