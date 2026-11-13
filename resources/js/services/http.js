function handleSession(res) {
    if (res.status === 401 || res.status === 419 || res.redirected) {
        window.location.reload();
        return true;
    }
    return false;
}

export async function fetchHtml(url) {
    const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    });
    if (handleSession(res)) return null;
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.text();
}

export async function fetchJson(url) {
    const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
    });
    if (handleSession(res)) return null;
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
}