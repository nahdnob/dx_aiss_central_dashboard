@props(['items', 'compact' => false])

<div {{ $attributes->class(['flex flex-col']) }}>
    <!-- Judul Utama -->
    <div @class(['w-full flex justify-center items-center', 'mb-3' => $compact, 'mb-4' => !$compact])>
        <p class="{{ $compact ? 'text-base' : 'text-xl' }} font-bold uppercase">Line Performance</p>
    </div>
    <!-- 3 Kolom -->
    <div @class(['w-full flex-1 grid grid-cols-1 md:grid-cols-3', 'gap-3' => $compact, 'gap-4' => !$compact])>
        @foreach ($items as $item)
            <!-- Kolom 1 -->
            <div @class(['flex flex-col items-center justify-center border rounded-lg bg-white', 'shadow-sm p-3' => $compact, 'shadow-lg p-4' => !$compact])>
                <p class="font-bold uppercase">{{ date('M', strtotime($item->month)) }} '{{ substr($item->year, -2) }}</p>
                <p class="mb-1 text-[11px] font-semibold text-gray-500">Target: {{ $item->target }}%</p>
                <img src="{{ $item->target > $item->actual ? asset('img/sad2.png') : asset('img/smile.png') }}" alt="Line A" @class(['object-contain', 'w-20 h-20 my-2' => $compact, 'w-36 h-32 mt-2 mb-3' => !$compact])>
                <p class="{{ $compact ? 'text-lg' : 'text-xl' }} font-bold {{ $item->target > $item->actual ? 'text-red-600' : 'text-green-600' }}">{{ $item->actual }}%</p>
            </div>
        @endforeach
    </div>
</div>