<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-6" x-data="{ open: @json($show ?? true) }" x-show="open" x-cloak>
    <div class="relative w-full max-w-2xl rounded-[32px] bg-slate-950/95 border border-white/10 p-8 shadow-2xl backdrop-blur-xl">
        <button type="button" @click="open = false" class="absolute right-5 top-5 text-slate-300 hover:text-white">×</button>

        <div class="grid gap-6 lg:grid-cols-[1.4fr_1fr]">
            <div class="rounded-3xl bg-slate-900/90 p-7 border border-white/10">
                <div class="flex items-center gap-3 text-slate-100 mb-6">
                    <div class="rounded-2xl bg-red-600/20 p-3 text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4S8 4.79 8 7s1.79 4 4 4zm0 0v6m-4 2h8" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-[0.24em] text-red-400/80">Login</p>
                        <h2 class="text-2xl font-bold text-white">Masuk ke AISS Dashboard</h2>
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-6">Gunakan NPK dan password Anda. Setelah login, pilih line produksi melalui modal yang muncul langsung di dashboard.</p>
                <div class="mt-8 grid gap-4 text-sm text-slate-300">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">Informasi penting</p>
                        <p class="mt-2 text-slate-400">Login terlebih dahulu, lalu pilih line dari modal.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">Desain tetap</p>
                        <p class="mt-2 text-slate-400">Tampilan mengikuti design awal dengan aksen merah dan gradien gelap.</p>
                    </div>
                </div>
            </div>
            <div class="rounded-[32px] bg-white p-8 shadow-xl">
                <x-auth.login-form />
            </div>
        </div>
    </div>
</div>
