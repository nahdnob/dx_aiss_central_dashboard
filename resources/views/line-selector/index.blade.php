<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Line — AISS Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        /* Animated background gradient */
        body {
            background: linear-gradient(135deg, #0f0f1a 0%, #1a0a2e 30%, #16213e 60%, #0f3460 100%);
            min-height: 100vh;
        }

        /* Floating orb animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-20px) scale(1.05); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(220, 38, 38, 0.3), 0 0 60px rgba(220, 38, 38, 0.1); }
            50%       { box-shadow: 0 0 40px rgba(220, 38, 38, 0.6), 0 0 100px rgba(220, 38, 38, 0.2); }
        }
        @keyframes card-shine {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .line-card {
            position: relative;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.03) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
            animation: fade-in-up 0.6s ease forwards;
        }
        .line-card:nth-child(2) { animation-delay: 0.15s; opacity: 0; }
        .line-card:nth-child(1) { animation-delay: 0.05s; opacity: 0; }

        .line-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.15) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .line-card:hover::before { opacity: 1; }
        .line-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(220, 38, 38, 0.5);
            box-shadow: 0 25px 60px rgba(0,0,0,0.4), 0 0 40px rgba(220, 38, 38, 0.15);
        }
        .line-card input[type="radio"]:checked ~ label .card-inner,
        .line-card:has(input:checked) {
            border-color: rgba(220, 38, 38, 0.8) !important;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2) 0%, rgba(220, 38, 38, 0.05) 100%);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 6s ease-in-out infinite;
        }

        .selected-ring {
            display: none;
            position: absolute;
            inset: -2px;
            border-radius: inherit;
            border: 2px solid #dc2626;
            animation: pulse-glow 2s ease-in-out infinite;
        }
        input[type="radio"]:checked + .selected-ring { display: block; }

        .submit-btn {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .submit-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }
        .submit-btn:hover::after { transform: translateX(100%); }
        .submit-btn:hover {
            box-shadow: 0 10px 40px rgba(220, 38, 38, 0.5);
            transform: translateY(-2px);
        }
        .submit-btn:active { transform: translateY(0); }

        /* Rotating border ring */
        .rotating-ring {
            animation: spin-slow 8s linear infinite;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen overflow-x-hidden">

    {{-- Ambient background orbs --}}
    <div class="orb w-96 h-96 bg-red-600 top-0 left-0 -translate-x-1/2 -translate-y-1/2" style="animation-delay: 0s;"></div>
    <div class="orb w-72 h-72 bg-blue-800 bottom-0 right-0 translate-x-1/3 translate-y-1/3" style="animation-delay: 2s;"></div>
    <div class="orb w-56 h-56 bg-purple-900 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" style="animation-delay: 4s;"></div>

    <div class="relative z-10 w-full max-w-2xl px-6 py-12">

        {{-- Logo / Brand Header --}}
        <div class="text-center mb-10" style="animation: fade-in-up 0.5s ease forwards;">
            {{-- Rotating Icon Ring --}}
            <div class="relative inline-flex items-center justify-center mb-6">
                {{-- Outer rotating ring --}}
                <div class="rotating-ring absolute w-28 h-28 rounded-full border-2 border-dashed border-red-500/30"></div>
                {{-- Inner glow circle --}}
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-red-600 to-red-900 flex items-center justify-center shadow-2xl" style="box-shadow: 0 0 40px rgba(220,38,38,0.4);">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" />
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl font-black text-white tracking-tight mb-2">
                AISS <span class="text-red-500">Dashboard</span>
            </h1>
            <p class="text-gray-400 text-sm font-medium uppercase tracking-widest">System Manager Access</p>
        </div>

        {{-- Info / Alert --}}
        @if(session('info'))
            <div class="mb-6 px-4 py-3 rounded-xl bg-yellow-500/10 border border-yellow-500/30 text-yellow-300 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('info') }}
            </div>
        @endif

        {{-- Card Container --}}
        <div class="relative rounded-3xl p-1" style="background: linear-gradient(135deg, rgba(220,38,38,0.3), rgba(255,255,255,0.05), rgba(220,38,38,0.1));">
            <div class="rounded-[22px] p-8" style="background: rgba(10,10,20,0.85); backdrop-filter: blur(30px);">

                <div class="mb-6">
                    <h2 class="text-xl font-bold text-white mb-1">Pilih Line Produksi</h2>
                    <p class="text-gray-400 text-sm">Pilih line yang ingin Anda kelola. Data yang tampil akan difilter berdasarkan pilihan ini.</p>
                </div>

                <form action="{{ route('line-selector.select') }}" method="POST" id="line-select-form">
                    @csrf

                    {{-- Validation Error --}}
                    @error('line_id')
                        <div class="mb-4 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Line Cards Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        @foreach($lines as $line)
                        <label for="line_{{ $line->id }}" class="cursor-pointer group">
                            <div class="line-card rounded-2xl p-6 relative">
                                <input
                                    type="radio"
                                    name="line_id"
                                    id="line_{{ $line->id }}"
                                    value="{{ $line->id }}"
                                    class="sr-only"
                                    {{ old('line_id') == $line->id ? 'checked' : '' }}
                                    onchange="document.getElementById('line-select-form').submit()"
                                >

                                {{-- Number Badge --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-lg"
                                         style="background: linear-gradient(135deg, rgba(220,38,38,0.3), rgba(220,38,38,0.1)); color: #f87171; border: 1px solid rgba(220,38,38,0.3);">
                                        {{ $loop->iteration }}
                                    </div>
                                    {{-- Checkmark (visible when selected) --}}
                                    <div class="check-icon w-6 h-6 rounded-full border-2 border-gray-600 flex items-center justify-center transition-all duration-300">
                                        <svg class="w-3 h-3 text-white hidden check-svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Line Name --}}
                                <div>
                                    <h3 class="text-white font-bold text-lg tracking-wide mb-1">{{ $line->name }}</h3>
                                    @if($line->businessUnit)
                                        <p class="text-gray-500 text-xs">{{ $line->businessUnit->name }}</p>
                                    @endif
                                </div>

                                {{-- Bottom decorative line --}}
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-red-600 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Submit Button (fallback jika JS disabled) --}}
                    <noscript>
                        <button type="submit" class="submit-btn w-full py-4 rounded-2xl text-white font-bold text-lg tracking-wide">
                            Masuk ke System Manager →
                        </button>
                    </noscript>

                </form>

                {{-- Footer Info --}}
                <div class="mt-6 pt-6 border-t border-white/5 flex items-center justify-between text-xs text-gray-600">
                    <span>Logged in as <span class="text-gray-400 font-medium">{{ Auth::user()->name }}</span></span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-400 transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Bottom branding --}}
        <p class="text-center text-gray-600 text-xs mt-8">
            DX AISS Central Dashboard &copy; {{ date('Y') }}
        </p>
    </div>

    <script>
        // Highlight selected card visually
        document.querySelectorAll('input[name="line_id"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Reset all cards
                document.querySelectorAll('.line-card').forEach(function(card) {
                    card.style.borderColor = '';
                    card.style.background  = '';
                    card.querySelector('.check-icon').style.background      = '';
                    card.querySelector('.check-icon').style.borderColor     = '';
                    card.querySelector('.check-svg').classList.add('hidden');
                });

                // Highlight the selected card
                const selectedCard = this.closest('label').querySelector('.line-card');
                selectedCard.style.borderColor = 'rgba(220, 38, 38, 0.8)';
                selectedCard.style.background  = 'linear-gradient(135deg, rgba(220,38,38,0.2) 0%, rgba(220,38,38,0.05) 100%)';
                selectedCard.querySelector('.check-icon').style.background  = '#dc2626';
                selectedCard.querySelector('.check-icon').style.borderColor = '#dc2626';
                selectedCard.querySelector('.check-svg').classList.remove('hidden');
            });
        });
    </script>

</body>
</html>
