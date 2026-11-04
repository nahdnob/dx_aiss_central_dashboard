import { login, validateCredentials, getErrorMessage } from '../services/auth';

export function initLogin() {
    const form = document.getElementById('login-form');
    if (!form) return;

    // ── Elements ──
    const btn     = document.getElementById('login-submit-btn');
    const label   = document.getElementById('login-submit-label');
    const errBox  = document.getElementById('login-error');
    const errText = document.getElementById('login-error-text');
    const toggle  = document.getElementById('toggle-password');
    const caps    = document.getElementById('caps-warning');
    const fields  = {
        npk:      document.getElementById('npk'),
        password: document.getElementById('password'),
    };

    // ── UI helpers ──
    const showError = msg => {
        errText.textContent = msg;
        errBox.classList.remove('hidden');
        errBox.classList.add('flex');
    };
    const hideError = () => {
        errBox.classList.add('hidden');
        errBox.classList.remove('flex');
    };
    const setLoading = loading => {
        btn.disabled = loading;
        label.textContent = loading ? 'Signing in...' : 'Sign In';
    };
    const onLoginSuccess = () => {
        if (document.getElementById('line-select-modal')) {
            window.Modal?.open('line-select-modal');
        } else {
            window.location.href = form.dataset.redirect;
        }
    };

    // ── Password field ──
    toggle.addEventListener('click', () => {
        const show = fields.password.type === 'password';
        fields.password.type = show ? 'text' : 'password';
        toggle.setAttribute('aria-pressed', String(show));
        toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });
    fields.password.addEventListener('keyup', e => {
        caps.classList.toggle('hidden', !e.getModifierState('CapsLock'));
    });
    fields.password.addEventListener('blur', () => caps.classList.add('hidden'));
    Object.values(fields).forEach(el => el.addEventListener('input', hideError));

    // ── Submit flow ──
    form.addEventListener('submit', async e => {
        e.preventDefault();
        if (btn.disabled) return;

        const invalid = validateCredentials({
            npk: fields.npk.value,
            password: fields.password.value,
        });
        if (invalid) {
            showError(invalid.message);
            fields[invalid.field].focus();
            return;
        }

        hideError();
        setLoading(true);
        let succeeded = false;

        try {
            const { ok, status, data } = await login(form.action, new FormData(form));

            if (ok) {
                succeeded = true;
                onLoginSuccess();
                return;
            }

            showError(getErrorMessage(status, data));
            fields.password.value = '';
            fields.password.focus();
        } catch {
            showError('Cannot reach the server. Check your connection and try again.');
        } finally {
            if (!succeeded) setLoading(false);
        }
    });
}