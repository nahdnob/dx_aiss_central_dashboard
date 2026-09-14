export default function initSearchableDropdowns() {
    document.querySelectorAll('[data-searchable-dropdown]').forEach(wrapper => {
        const id = wrapper.dataset.searchableDropdown;

        const button   = document.getElementById(`dropdown-${id}-button`);
        const dropdown = document.getElementById(`dropdown-${id}-search`);
        const search   = document.getElementById(`dropdown-${id}-search-input`);
        const hidden   = document.getElementById(`dropdown-${id}-hidden`);
        const text     = document.getElementById(`dropdown-${id}-text`);
        const options  = wrapper.querySelectorAll('.dropdown-option');

        if (!button || !dropdown) return;

        // Samakan lebar dropdown dengan lebar tombol setiap kali dibuka
        button.addEventListener('click', () => {
            dropdown.style.width = `${button.offsetWidth}px`;
        });

        window.addEventListener('resize', () => {
            if (!dropdown.classList.contains('hidden')) {
                dropdown.style.width = `${button.offsetWidth}px`;
            }
        });

        // Search filter
        if (search) {
            search.addEventListener('input', () => {
                const keyword = search.value.toLowerCase();
                options.forEach(opt => {
                    opt.closest('li').style.display = opt.dataset.value.toLowerCase().includes(keyword) ? '' : 'none';
                });
            });
        }

        // Select option
        options.forEach(opt => {
            opt.addEventListener('click', e => {
                e.preventDefault();
                hidden.value = opt.dataset.id;
                text.textContent = opt.dataset.value;
                if (search) search.value = '';
                options.forEach(o => o.closest('li').style.display = '');
                dropdown.classList.add('hidden');
            });
        });
    });
}