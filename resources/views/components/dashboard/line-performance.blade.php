@props(['items'])

<div>
    <!-- Judul Utama -->
    <div class="w-full flex justify-center items-center mb-4">
        <p class="text-xl font-bold uppercase">Line Performance</p>
    </div>
    <!-- 3 Kolom -->
    <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($items as $item)
            <!-- Kolom 1 -->
            <div class="flex flex-col items-center border rounded-lg shadow-lg p-4">
                <p class="mb-2 font-bold uppercase">{{ date('M', strtotime($item->month)) }} '{{ substr($item->year, -2) }}</p>
                <img src="{{ $item->target > $item->actual ? asset('img/sad2.png') : asset('img/smile.png') }}" alt="Line A" class="w-36 h-32 object-contain mt-2 mb-3">
                <p class="text-xl font-bold {{ $item->target > $item->actual ? 'text-red-600' : 'text-green-600' }}">{{ $item->actual }}%</p>
            </div>
        @endforeach
    </div>
</div>