@props(['dayCount', 'lastDay', 'fluid' => false])

<!-- Outer Card -->
<div {{ $attributes->class(['min-w-80 p-1 rounded-[28px] bg-gradient-to-r from-yellow-300 via-orange-400 to-yellow-300 shadow-xl', 'w-full' => $fluid, 'w-auto' => !$fluid]) }}>
    <!-- Inner Card -->
    <div class="w-full p-5 bg-yellow-50 rounded-3xl">
        <div class="flex items-center justify-center gap-2">
            <svg class="w-[50px] h-[50px] md:w-[75px] md:h-[75px]" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M39.37 18.432c0 3.058-.906 5.862-2.466 8.203a14.728 14.728 0 0 1-10.079 6.367c-.717.127-1.455.19-2.214.19-.759 0-1.497-.063-2.214-.19a14.728 14.728 0 0 1-10.078-6.368 14.692 14.692 0 0 1-2.467-8.202c0-8.16 6.6-14.76 14.76-14.76s14.759 6.6 14.759 14.76Z" stroke="rgb(234 88 12)" stroke-width="3.473" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="m44.712 38.17-3.431.83a2.063 2.063 0 0 0-1.539 1.572l-.728 3.122c-.09.384-.281.734-.554 1.012a2.068 2.068 0 0 1-.992.564c-.375.09-.768.073-1.134-.052a2.078 2.078 0 0 1-.938-.653l-9.92-11.64-9.92 11.661a2.078 2.078 0 0 1-.938.653 2.038 2.038 0 0 1-1.134.052 2.067 2.067 0 0 1-.992-.563 2.137 2.137 0 0 1-.554-1.012l-.728-3.123a2.13 2.13 0 0 0-.55-1.01 2.06 2.06 0 0 0-.988-.562L6.24 38.19a2.073 2.073 0 0 1-.956-.533 2.14 2.14 0 0 1-.563-.953 2.175 2.175 0 0 1-.015-1.113c.091-.366.276-.7.536-.97l8.11-8.284a14.672 14.672 0 0 0 4.307 4.281 14.34 14.34 0 0 0 5.634 2.134 12.29 12.29 0 0 0 2.183.191c.749 0 1.477-.063 2.184-.19 4.138-.617 7.694-3.017 9.94-6.416l8.11 8.285c1.144 1.147.583 3.165-.998 3.547Zm-18.03-26.532 1.227 2.507c.167.34.603.68.998.743l2.226.383c1.414.233 1.747 1.296.727 2.336l-1.726 1.764c-.29.297-.457.87-.353 1.295l.499 2.188c.395 1.721-.5 2.4-1.996 1.487l-2.08-1.253a1.434 1.434 0 0 0-1.372 0l-2.08 1.253c-1.497.892-2.392.234-1.996-1.487l.499-2.188c.083-.403-.063-.998-.354-1.295l-1.726-1.764c-1.019-1.04-.686-2.081.728-2.336l2.225-.383c.375-.063.811-.403.977-.743l1.227-2.507c.604-1.36 1.685-1.36 2.35 0Z" stroke="rgb(234 88 12)" stroke-width="3.473" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <p class="text-6xl font-extrabold">
                {{ $dayCount }}
            </p>
        </div>
        <p class="text-3xl font-extrabold italic text-center tracking-wide">BEST RECORD</p>
        <p class="text-base font-medium text-center text-gray-400">No Claim since</p>
        <a href="javascript:void(0)" id="openCardClaim" class="block text-sm font-bold text-center text-orange-600 hover:underline">
            {{ $lastDay->format('d M Y') }}
        </a>
    </div>
</div>