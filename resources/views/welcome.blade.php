<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Production Line</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

    <style>
        html { scroll-behavior: smooth; }
        .swiper { width: 480px; height: 75vh; overflow: visible; }
        .swiper-slide { display: flex; justify-content: center; align-items: center; }
        .line-card {
            width: 100%; height: 420px; border-radius: 30px;
            background: linear-gradient(135deg, white, #fafafa);
            border: 2px solid #dc2626; transition: .4s;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            cursor: pointer; overflow: hidden; position: relative;
        }
        .swiper-slide-active .line-card { transform: scale(1); box-shadow: 0 25px 50px rgba(0,0,0,.18); }
        .swiper-slide-next .line-card, .swiper-slide-prev .line-card { transform: scale(.88); opacity: .25; filter: blur(1px); }
        .swiper-pagination-bullet { width: 12px; height: 12px; background: #d1d5db; opacity: 1; }
        .swiper-pagination-bullet-active { background: #dc2626; height: 30px; border-radius: 20px; }
        .line-card:hover { transform: translateY(-5px); }
        #selectedLine, #selectedDesc { transition: .4s; }
        .line-card::before {
            content: ""; position: absolute; width: 300px; height: 300px;
            background: #fee2e2; border-radius: 50%; top: -160px; right: -160px; transition: .4s;
        }
        .swiper-slide-active .line-card::before { transform: scale(1.3); }
        .line-card > * { position: relative; z-index: 2; }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-100 via-white to-red-50 h-screen overflow-hidden" x-data="{ showLogin: false, selectedLineForLogin: '' }">
    <div class="w-full h-full relative">
        <!-- HEADER -->
        <header class="h-20 flex items-center justify-between px-16">
            <div>
                <h1 class="font-black text-2xl">DENSO</h1>
                <p class="text-gray-500">Production Monitoring System</p>
            </div>
            <div id="clock" class="text-right">
                <div class="text-2xl font-bold"></div>
                <div class="text-gray-500"></div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="grid grid-cols-12 h-[calc(100vh-80px)]">
            <!-- LEFT -->
            <section class="col-span-5 flex flex-col justify-center pl-20">
                <p class="uppercase tracking-[6px] text-gray-400">Select Production Line</p>
                <h2 id="selectedLine" class="text-[170px] font-black leading-none mt-6">L1</h2>
                <h3 id="selectedDesc" class="text-3xl text-gray-500">Assembly Line</h3>
                <div class="mt-10 flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-gray-500">Swipe or use mouse wheel</span>
                </div>
            </section>

            <!-- RIGHT -->
            <section class="col-span-7 flex justify-center items-center">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <!-- LINE 1 -->
                        <div class="swiper-slide" data-line="L1" data-desc="Assembly Line">
                            <div class="line-card" @click="selectedLineForLogin = 'L1'; showLogin = true">
                                <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="ri-settings-5-line text-5xl text-red-600"></i>
                                </div>
                                <h2 class="text-5xl font-black mt-8">LINE 1</h2>
                                <p class="text-gray-500 mt-4 text-xl">Assembly Line</p>
                            </div>
                        </div>

                        <!-- LINE 2 -->
                        <div class="swiper-slide" data-line="L2" data-desc="Machining">
                            <div class="line-card" @click="selectedLineForLogin = 'L2'; showLogin = true">
                                <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="ri-settings-3-line text-5xl text-red-600"></i>
                                </div>
                                <h2 class="text-5xl font-black mt-8">LINE 2</h2>
                                <p class="text-gray-500 mt-4 text-xl">Machining</p>
                            </div>
                        </div>

                        <!-- LINE 3 -->
                        <div class="swiper-slide" data-line="L3" data-desc="Welding">
                            <div class="line-card" @click="selectedLineForLogin = 'L3'; showLogin = true">
                                <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="ri-hammer-line text-5xl text-red-600"></i>
                                </div>
                                <h2 class="text-5xl font-black mt-8">LINE 3</h2>
                                <p class="text-gray-500 mt-4 text-xl">Welding</p>
                            </div>
                        </div>

                        <!-- LINE 4 -->
                        <div class="swiper-slide" data-line="L4" data-desc="Inspection">
                            <div class="line-card" @click="selectedLineForLogin = 'L4'; showLogin = true">
                                <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="ri-search-eye-line text-5xl text-red-600"></i>
                                </div>
                                <h2 class="text-5xl font-black mt-8">LINE 4</h2>
                                <p class="text-gray-500 mt-4 text-xl">Inspection</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>
        </main>
    </div>

    <!-- Login Modal -->
    <div x-show="showLogin" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div @click.outside="showLogin = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 relative">
            <button @click="showLogin = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-user-3-line text-3xl text-red-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">Welcome Back</h3>
                <p class="text-gray-500 mt-1">Please login to <span class="font-bold text-red-600" x-text="selectedLineForLogin"></span></p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="hidden" name="line" x-bind:value="selectedLineForLogin">

                <div class="mb-5">
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Username / NPK</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" placeholder="Enter your NPK" required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-red-200">
                    Login to System
                </button>
            </form>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.querySelector("#clock .text-2xl").innerHTML = now.toLocaleTimeString("id-ID");
            document.querySelector("#clock .text-gray-500").innerHTML = now.toLocaleDateString("id-ID", {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
        
        updateClock();
        setInterval(updateClock, 1000);

        const swiper = new Swiper(".swiper", {
            direction: "vertical",
            effect: "coverflow",
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 150,
                modifier: 1,
                scale: 0.9,
                slideShadows: false,
            },
            slidesPerView: 1.35,
            centeredSlides: true,
            spaceBetween: 30,
            speed: 700,
            grabCursor: true,
            mousewheel: {
                forceToAxis: true,
                sensitivity: 0.7,
            },
            loop: true,
            keyboard: {
                enabled: true,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            on: {
                init: function () {
                    updatePreview(this);
                },
                slideChangeTransitionEnd: function () {
                    updatePreview(this);
                }
            }
        });

        function updatePreview(swiper) {
            const slide = swiper.slides[swiper.activeIndex];
            const line = slide.dataset.line;
            const desc = slide.dataset.desc;
            document.getElementById("selectedLine").innerHTML = line;
            document.getElementById("selectedDesc").innerHTML = desc;
        }
    </script>
</body>
</html>