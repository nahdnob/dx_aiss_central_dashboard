import { fetchHtml } from '../services/http';
import { createPoller } from './poller';

const pollers = new WeakMap();

export function initAutoRefresh(root = document) {
    root.querySelectorAll('[data-refresh-url]').forEach((el) => {
        if (pollers.has(el)) return; // sudah aktif

        const interval = Number(el.dataset.refreshInterval) || 5000;

        const poller = createPoller(async () => {
            if (!el.isConnected) {
                poller.stop();
                pollers.delete(el);
                return;
            }

            const html = await fetchHtml(el.dataset.refreshUrl + window.location.search);
            if (html === null) return;

            el.innerHTML = html;
            el.dispatchEvent(new CustomEvent('refresh:updated', { bubbles: true }));
        }, interval);

        pollers.set(el, poller);
        poller.start();
    });
}

export function stopAutoRefresh(el) {
    pollers.get(el)?.stop();
    pollers.delete(el);
}