@php

    $type = null;
    $message = null;

    if(session()->has('success')){
        $type = 'success';
        $message = session('success');
    }
    elseif(session()->has('error')){
        $type = 'error';
        $message = session('error');
    }
    elseif(session()->has('warning')){
        $type = 'warning';
        $message = session('warning');
    }
    elseif(session()->has('info')){
        $type = 'info';
        $message = session('info');
    }
    elseif($errors->any()){
        $type = 'error';
        $message = $errors->first();
    }

    $styles = [

        'success' => [
            'title' => 'Success',
            'bg' => 'bg-emerald-50',
            'icon' => 'text-emerald-600',
            'progress' => 'from-emerald-500 to-green-600',
            'hover' => 'hover:text-emerald-600',
        ],

        'error' => [
            'title' => 'Error',
            'bg' => 'bg-red-50',
            'icon' => 'text-red-600',
            'progress' => 'from-red-500 to-red-700',
            'hover' => 'hover:text-red-600',
        ],

        'warning' => [
            'title' => 'Warning',
            'bg' => 'bg-yellow-50',
            'icon' => 'text-yellow-600',
            'progress' => 'from-yellow-400 to-orange-500',
            'hover' => 'hover:text-yellow-600',
        ],

        'info' => [
            'title' => 'Information',
            'bg' => 'bg-sky-50',
            'icon' => 'text-sky-600',
            'progress' => 'from-sky-500 to-blue-600',
            'hover' => 'hover:text-sky-600',
        ],

    ];

@endphp

@if($type)

<div
    id="toast"
    class="fixed bottom-6 right-6 z-[9999] w-[380px]
           bg-white border border-gray-200 rounded-2xl
           shadow-2xl overflow-hidden
           translate-x-[120%]
           transition-all duration-500">

    <div
        id="toast-progress"
        class="absolute top-0 left-0 h-1 bg-gradient-to-r {{ $styles[$type]['progress'] }}">
    </div>

    <div class="flex items-start gap-4 p-5">

        <div class="w-11 h-11 rounded-xl {{ $styles[$type]['bg'] }} flex items-center justify-center shrink-0">

            @if($type=='success')

                <svg class="w-6 h-6 {{ $styles[$type]['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7"/>
                </svg>

            @elseif($type=='error')

                <svg class="w-6 h-6 {{ $styles[$type]['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>

            @elseif($type=='warning')

                <svg class="w-6 h-6 {{ $styles[$type]['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86L1.82 18A2 2 0 003.53 21h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>

            @else

                <svg class="w-6 h-6 {{ $styles[$type]['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01"/>
                </svg>

            @endif

        </div>

        <div class="flex-1">

            <h4 class="font-bold text-gray-900">
                {{ $styles[$type]['title'] }}
            </h4>

            <p class="mt-1 text-sm text-gray-500">
                {{ $message }}
            </p>

        </div>

        <button
            onclick="closeToast()"
            class="text-gray-400 {{ $styles[$type]['hover'] }}">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"/>

            </svg>

        </button>

    </div>

</div>


@endif