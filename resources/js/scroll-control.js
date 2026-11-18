/**
 * Scroll Control (Alpine component)
 *
 * Kontrol scroll melayang di pojok kanan:
 *  - Tombol atas  : scroll halus ke paling atas.
 *  - Tombol bawah : scroll halus ke paling bawah.
 *  - Mode auto    : halaman bergerak sendiri bolak-balik (bawah mentok -> jeda -> atas mentok -> jeda -> ...).
 *  - Auto otomatis jeda saat user scroll manual / hover, lalu lanjut lagi setelah idle.
 */
export default function scrollControl({
    auto = true,      // mulai dalam mode auto-scroll
    speed = 150,      // kecepatan auto-scroll (px per detik)
    pause = 15000,    // jeda di ujung atas/bawah (ms)
    resume = 5000,    // lanjut auto setelah user diam (ms)
} = {}) {
    return {
        auto,
        direction: 'down',   // arah auto-scroll saat ini
        progress: 0,          // 0..1 posisi scroll
        edge: 'top',          // ujung terakhir yang dicapai (penanda warna merah)
        scrollable: false,
        hovering: false,

        _raf: null,
        _last: null,
        _pos: 0,
        _holdUntil: 0,

        init() {
            // Pilihan jeda/jalan user tetap dipakai setelah halaman di-reload (meta refresh)
            const saved = readSaved()
            if (saved !== null) this.auto = saved

            this.measure()
            this._pos = window.scrollY

            window.addEventListener('scroll', () => this.measure(), { passive: true })
            window.addEventListener('resize', () => this.measure())
            new ResizeObserver(() => this.measure()).observe(document.body)

            // Interaksi manual user -> tahan auto-scroll sementara
            const userInput = () => this.hold(resume)
            ;['wheel', 'touchstart', 'keydown', 'mousedown'].forEach(evt =>
                window.addEventListener(evt, (e) => {
                    if (this.$root.contains(e.target)) return
                    userInput()
                }, { passive: true })
            )

            this._raf = requestAnimationFrame(t => this.tick(t))
        },

        destroy() {
            cancelAnimationFrame(this._raf)
        },

        get maxScroll() {
            return Math.max(0, document.documentElement.scrollHeight - window.innerHeight)
        },

        get atTop() {
            return this.progress <= 0.005
        },

        get atBottom() {
            return this.progress >= 0.995
        },

        measure() {
            const max = this.maxScroll
            this.scrollable = max > 4
            this.progress = max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0
            if (this.atTop) this.edge = 'top'
            else if (this.atBottom) this.edge = 'bottom'
            // Sinkron ulang hanya jika posisi berubah karena hal lain (user / tombol),
            // bukan selisih pembulatan dari auto-scroll sendiri.
            if (Math.abs(window.scrollY - this._pos) > 2) this._pos = window.scrollY
        },

        hold(ms) {
            this._holdUntil = performance.now() + ms
        },

        tick(now) {
            const dt = this._last ? (now - this._last) / 1000 : 0
            this._last = now

            if (this.auto && this.scrollable && !this.hovering && now >= this._holdUntil) {
                const max = this.maxScroll
                const step = speed * Math.min(dt, 0.1) * (this.direction === 'down' ? 1 : -1)

                this._pos = Math.min(max, Math.max(0, this._pos + step))
                window.scrollTo(0, this._pos)

                if (this._pos >= max) {
                    this.direction = 'up'
                    this.hold(pause)
                } else if (this._pos <= 0) {
                    this.direction = 'down'
                    this.hold(pause)
                }
            }

            this._raf = requestAnimationFrame(t => this.tick(t))
        },

        toTop() {
            this.direction = 'down'
            this.hold(pause)
            window.scrollTo({ top: 0, behavior: 'smooth' })
        },

        toBottom() {
            this.direction = 'up'
            this.hold(pause)
            window.scrollTo({ top: this.maxScroll, behavior: 'smooth' })
        },

        toggleAuto() {
            this.auto = !this.auto
            this._pos = window.scrollY
            this._holdUntil = 0
            saveState(this.auto)
        },
    }
}

const STORAGE_KEY = 'scrollControl.auto'

function readSaved() {
    try {
        const v = localStorage.getItem(STORAGE_KEY)
        return v === null ? null : v === '1'
    } catch {
        return null
    }
}

function saveState(auto) {
    try {
        localStorage.setItem(STORAGE_KEY, auto ? '1' : '0')
    } catch {
        // storage tidak tersedia (private mode, dll) — abaikan
    }
}
