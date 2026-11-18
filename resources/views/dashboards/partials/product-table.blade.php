{{-- Scroll (vertikal & horizontal) diatur oleh container pembungkus, bukan di sini,
     supaya header sticky menempel di atas area scroll tersebut.
     Tinggi TETAP: header 56px + baris 74px. Garis pemisah memakai inset shadow
     (tidak menambah tinggi), sehingga 6 baris = 56 + 6 x 74 = 500px.
     Jika tinggi ini diubah, sesuaikan juga h-[500px] di system-managers/index. --}}
<div class="relative sm:rounded-lg">
@if (count($products) > 0)
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="sticky top-0 z-10 text-xs font-bold text-white uppercase bg-gray-700 shadow-[inset_0_-2px_0_#1f2937]">
            <tr class="h-14">
                <th scope="col" class="px-6 py-0 text-sm tracking-wide text-center">Part Number</th>
                <th scope="col" class="px-6 py-0 text-sm tracking-wide text-center">Time In</th>
                <th scope="col" class="px-6 py-0 text-sm tracking-wide text-center">Qty</th>
                <th scope="col" class="px-6 py-0 text-sm tracking-wide text-center">Status</th>
                <th scope="col" class="px-6 py-0 text-sm tracking-wide text-center">Out Estimate</th>
            </tr>
        </thead>
        <tbody>
			@foreach ($products as $product)
				<tr class="h-[74px] bg-white shadow-[inset_0_-1px_0_#e5e7eb]">
					<th scope="row" class="px-6 py-0">
						<p class="font-medium text-lg text-slate-700 whitespace-nowrap">
							{{ $product['part_number'] }}
						</p>
					</th>
					<td class="px-6 py-0">
						<div class="flex items-center gap-3">
							<div class="flex flex-col">
								<p class="block antialiased font-sans text-lg leading-normal text-slate-700 font-normal">{{ \Carbon\Carbon::parse($product['time_in'])->format('H:i:s') }}</p>
								<p class="block antialiased font-sans text-xs leading-normal text-slate-700 font-normal opacity-70">Date: {{ \Carbon\Carbon::parse($product['time_in'])->format('j F Y') }}</p>
							</div>
						</div>
					</td>
					<td class="px-6 py-0">
						<p class="font-medium text-lg text-slate-700 text-center whitespace-nowrap">
							{{ $product['quantity'] }}
						</p>
					</td>
					<td class="px-6 py-0">
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
					<td class="px-6 py-0 text-right">
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
