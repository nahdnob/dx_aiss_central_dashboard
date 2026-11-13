export function createPoller(task, interval = 5000) {
    let timer;
    let running = false;

    const schedule = () => {
        clearTimeout(timer);
        if (running && !document.hidden) timer = setTimeout(run, interval);
    };

    const run = async () => {
        try {
            await task();
        } catch (e) {
            console.error(e);
        } finally {
            schedule();
        }
    };

    const onVisibility = () => {
        if (document.hidden) clearTimeout(timer);
        else if (running) run();
    };

    return {
        start() {
            if (running) return;
            running = true;
            document.addEventListener('visibilitychange', onVisibility);
            schedule();
        },
        stop() {
            running = false;
            clearTimeout(timer);
            document.removeEventListener('visibilitychange', onVisibility);
        },
    };
}