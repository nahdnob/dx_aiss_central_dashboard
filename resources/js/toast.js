class Toast {

    constructor() {
        this.init();
    }

    init() {

        document.addEventListener('DOMContentLoaded', () => {

            this.toast = document.getElementById('toast');
            this.progress = document.getElementById('toast-progress');

            if (!this.toast) return;

            setTimeout(() => {
                this.toast.classList.remove('translate-x-[120%]');
            }, 100);

            this.progress.style.width = '100%';

            setTimeout(() => {
                this.progress.style.transition = 'width 4s linear';
                this.progress.style.width = '0%';
            }, 100);

            setTimeout(() => {
                this.close();
            }, 4100);

        });

    }

    close() {

        if (!this.toast) return;

        this.toast.classList.add('translate-x-[120%]');

        setTimeout(() => {
            this.toast.remove();
        }, 500);

    }

    static styles = {
        success: { title: 'Success', bg: 'bg-emerald-50', icon: 'text-emerald-600', progress: 'from-emerald-500 to-green-600', hover: 'hover:text-emerald-600', path: 'M5 13l4 4L19 7' },
        error: { title: 'Error', bg: 'bg-red-50', icon: 'text-red-600', progress: 'from-red-500 to-red-700', hover: 'hover:text-red-600', path: 'M6 18L18 6M6 6l12 12' },
        warning: { title: 'Warning', bg: 'bg-yellow-50', icon: 'text-yellow-600', progress: 'from-yellow-400 to-orange-500', hover: 'hover:text-yellow-600', path: 'M12 9v4m0 4h.01M10.29 3.86L1.82 18A2 2 0 003.53 21h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z' },
        info: { title: 'Information', bg: 'bg-sky-50', icon: 'text-sky-600', progress: 'from-sky-500 to-blue-600', hover: 'hover:text-sky-600', path: 'M13 16h-1v-4h-1m1-4h.01' },
    };

    // Programmatically fire a toast identical in markup/style to the server-rendered one (x-ui.toast.blade.php),
    // for AJAX flows where there's no page reload to render the session-flash version.
    static fire(message, type = 'info') {

        const existing = document.getElementById('toast');
        if (existing) existing.remove();

        const s = Toast.styles[type] || Toast.styles.info;

        const el = document.createElement('div');
        el.id = 'toast';
        el.className = 'fixed bottom-6 right-6 z-[9999] w-[380px] bg-white border border-gray-200 rounded-2xl shadow-2xl overflow-hidden translate-x-[120%] transition-all duration-500';
        el.innerHTML = `
            <div id="toast-progress" class="absolute top-0 left-0 h-1 bg-gradient-to-r ${s.progress}"></div>
            <div class="flex items-start gap-4 p-5">
                <div class="w-11 h-11 rounded-xl ${s.bg} flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 ${s.icon}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="${s.path}"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-900">${s.title}</h4>
                    <p class="mt-1 text-sm text-gray-500"></p>
                </div>
                <button type="button" class="toast-fire-close text-gray-400 ${s.hover}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;
        el.querySelector('p').textContent = message;

        const dismiss = () => {
            el.classList.add('translate-x-[120%]');
            setTimeout(() => el.remove(), 500);
        };
        el.querySelector('.toast-fire-close').addEventListener('click', dismiss);

        document.body.appendChild(el);

        const progress = el.querySelector('#toast-progress');
        requestAnimationFrame(() => el.classList.remove('translate-x-[120%]'));
        progress.style.width = '100%';
        setTimeout(() => {
            progress.style.transition = 'width 4s linear';
            progress.style.width = '0%';
        }, 100);
        setTimeout(dismiss, 4100);
    }

}

export default Toast;