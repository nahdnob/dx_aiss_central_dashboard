@props(['products'])

<div class="h-full overflow-auto p-3">
    <table class="w-full text-sm">
        
        @if (count($products) > 0)

        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-base text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4">Part Number</th>
                        <th scope="col" class="px-6 py-4">Time In</th>
                        <th scope="col" class="px-6 py-4">Qty</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4">Out Estimate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="bg-white border-b border-gray-200">
                            <th scope="row" class="px-6 py-3.5">
                                <p class="font-medium text-lg text-slate-700 whitespace-nowrap">
                                    {{ $product['part_number'] }}
                                </p>
                            </th>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex flex-col">
                                        <p class="block antialiased font-sans text-lg leading-normal text-slate-700 font-normal">{{ \Carbon\Carbon::parse($product['time_in'])->format('H:i:s') }}</p>
                                        <p class="block antialiased font-sans text-xs leading-normal text-slate-700 font-normal opacity-70">Date: {{ \Carbon\Carbon::parse($product['time_in'])->format('j F Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <p class="font-medium text-lg text-slate-700 text-center whitespace-nowrap">
                                    {{ $product['quantity'] }}
                                </p>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="w-max">
                                    @php
                                        $bgColorClass  = match($product['status']) {

                                            'SUB ASSY'   => 'bg-green-500/20 text-green-600',
                                            'PREHEAT'    => 'bg-yellow-500/20 text-yellow-600',
                                            'HARDENING'  => 'bg-orange-500/20 text-orange-600',
                                            'INSPECTION' => 'bg-blue-500/20 text-blue-600',
                                            'HILANG'     => 'bg-blue-500/20 text-blue-600',
                                            default      => 'bg-gray-500/20 text-gray-600',
                                        };
                                    @endphp
                                    <div class="relative grid w-28 items-center font-sans font-bold uppercase whitespace-nowrap select-none {{ $bgColorClass }} py-1 px-2 text-sm text-center rounded-md" style="opacity: 1;">
                                        <span class="">{{$product['status']}}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <div class="flex items-center gap-3">
                                    <div class="flex flex-col">
                                        <p class="block antialiased font-sans text-lg leading-normal text-slate-700 font-normal">{{ \Carbon\Carbon::parse($product['estimate'])->add(new DateInterval('PT4H'))->format('H:i:s') }}</p>
                                        <p class="block antialiased font-sans text-xs leading-normal text-slate-700 font-normal opacity-70">Date: {{ \Carbon\Carbon::parse($product['estimate'])->add(new DateInterval('PT4H'))->format('j F Y') }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-danger text-center text-red-600">
                TIDAK ADA PRODUK DI WIP!
            </div>
        @endif
        </div>

    </table>
</div>
