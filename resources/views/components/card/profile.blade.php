@props([
    'name',
    'email' => null,
    'npk',
    'image',
    'verified' => false,
])

<div class="w-[360px] max-w-[90vw] mx-auto bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 relative overflow-hidden border border-gray-100 dark:border-gray-700">
    
    <!-- Decorative Theme Line -->
    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-sky-200 from-20% via-red-600 via-60% to-rose-900"></div>

    {{-- Photo --}}
    <div class="flex justify-center mb-6 mt-2 relative">
        <div class="w-32 h-32 rounded-full overflow-hidden shadow-lg ring-4 ring-sky-200 dark:ring-sky-900/50">
            <img src="{{ $image }}"
                 alt="{{ $name }}"
                 class="w-full h-full object-cover">
        </div>
        @if($verified)
        <div class="absolute bottom-1 right-1/4 translate-x-2 bg-white rounded-full p-1.5 shadow-md">
            <svg class="w-5 h-5 text-sky-500"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor"
                 viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        @endif
    </div>

    {{-- Name & Title --}}
    <div class="text-center space-y-1 mb-6">
        <h2 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-red-600">
            {{ $name }}
        </h2>
        
        @if($npk)
             <p class="text-sm font-bold text-gray-500 dark:text-gray-400 tracking-wider">
                NPK: {{ $npk }}
            </p>
        @endif
    </div>

    {{-- Biodata Container --}}
    <div class="bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <dl class="space-y-4 text-sm">
            @if($email)
            <div>
                <dt class="text-xs text-gray-400 dark:text-gray-500 font-bold uppercase tracking-wide mb-1">Email Address</dt>
                <dd class="font-medium text-gray-800 dark:text-gray-200 break-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ $email }}
                </dd>
            </div>
            @endif

            <div>
                <dt class="text-xs text-gray-400 dark:text-gray-500 font-bold uppercase tracking-wide mb-1">Phone Number</dt>
                <dd class="font-medium text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    085123123123
                </dd>
            </div>
        </dl>
    </div>
</div>