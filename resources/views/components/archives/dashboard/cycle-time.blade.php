@props([
    'patterns',
    'patternId'
])

<div class="h-full flex items-center justify-center">
    <div class="h-full overflow-auto p-2">

        <form id="pattern-form" method="POST" class="flex gap-4 items-center">
            @csrf

            <select name="pattern"
                class="border border-gray-400 text-sm rounded-lg p-2.5">
                @foreach ($patterns as $pattern)
                    <option
                        value="{{ $pattern->id }}"
                        @selected($patternId == $pattern->id)
                    >
                        {{ $pattern->name }}
                    </option>
                @endforeach
            </select>

            <button class="bg-slate-400 text-white font-bold px-5 py-2.5 rounded-md">
                APPLY
            </button>
        </form>

        <div class="flex bg-white p-4 my-4 rounded-md h-[420px] w-[850px]">
            <canvas
                id="chart_main"
                data-pattern="{{ $patternId }}">
            </canvas>
        </div>

    </div>
</div>
