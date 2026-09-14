export default function initToggleList() {
    document.querySelectorAll('[data-toggle-search]').forEach(searchEl => {
        const id     = searchEl.dataset.toggleSearch;
        const listEl = document.querySelector(`[data-toggle-list="${id}"]`);

        if (!listEl) return;

        searchEl.addEventListener('input', () => {
            const keyword = searchEl.value.toLowerCase();
            listEl.querySelectorAll('.toggle-list-item').forEach(item => {
                const name = item.dataset.name || '';
                item.style.display = name.includes(keyword) ? '' : 'none';
            });
        });
    });
}