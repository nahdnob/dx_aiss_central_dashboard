// Validasi input; kembalikan null jika valid
export function validateCredentials({ npk, password }) {
    if (!npk.trim()) return { message: 'Please enter your NPK.', field: 'npk' };
    if (!password)   return { message: 'Please enter your password.', field: 'password' };
    return null;
}

// Kirim request login; throw error jika jaringan gagal
export async function login(url, formData) {
    const res  = await fetch(url, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData,
    });
    const data = await res.json().catch(() => ({}));

    return { ok: res.ok && data.success === true, status: res.status, data };
}

// Tentukan pesan error dari status HTTP dan isi respons
export function getErrorMessage(status, data = {}) {
    if (status === 419) return 'Your session has expired. Please refresh the page and try again.';
    if (status === 429) return 'Too many attempts. Please wait a moment and try again.';
    if (status >= 500)  return 'Server error. Please try again or contact the administrator.';
    return data.message
        || (data.errors && Object.values(data.errors)[0]?.[0])
        || 'Incorrect NPK or password.';
}