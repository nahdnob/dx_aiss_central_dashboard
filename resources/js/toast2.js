class Toast2 {

    static container = null;

    static init() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.className =
                "fixed top-20 left-1/2 -translate-x-1/2 z-[9999] w-96 space-y-3";
            document.body.appendChild(this.container);
        }
    }

    static show(message, type = 'success', duration = 3000) {
        this.init();

        const icons = {
            success: `<svg class="w-7 h-7 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            error: `<svg class="w-7 h-7 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`,
            warning: `<svg class="w-7 h-7 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            info: `<svg class="w-7 h-7 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
        };

        const toast = document.createElement('div');
        toast.className =
            `relative bg-white/40 dark:bg-gray-800/40 backdrop-blur-xl border border-white/50 shadow-2xl rounded-2xl flex items-center gap-3 px-5 py-4
             transform transition-all duration-300 opacity-0 translate-y-2`;

        toast.innerHTML = `
            <div>${icons[type]}</div>
            <div class="flex-1 text-[15px] font-bold tracking-wide text-gray-800 dark:text-gray-100">${message}</div>
            <button class="text-gray-400 hover:text-gray-700 transition-colors text-2xl leading-none -mt-1">&times;</button>
        `;

        // Close button
        toast.querySelector('button').addEventListener('click', () => {
            this.hide(toast);
        });

        this.container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('opacity-0', 'translate-y-2');
            toast.classList.add('opacity-100', 'translate-y-0');
        });

        // Auto hide
        setTimeout(() => {
            this.hide(toast);
        }, duration);
    }

    static hide(toast) {
        toast.classList.remove('opacity-100', 'translate-y-0');
        toast.classList.add('opacity-0', 'translate-y-2');

        setTimeout(() => {
            toast.remove();
        }, 300);
    }
}

export default Toast;