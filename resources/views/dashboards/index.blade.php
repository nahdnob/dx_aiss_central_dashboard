@extends('layouts.app')

@section('header')
	<h1 class="text-4xl font-bold tracking-tight text-gray-900 text-center">
		<span class="bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-rose-900 italic">AISS</span>
		<span class="font-semibold">{{ $title }}</span>
	</h1>
@endsection

@section('content')
	<div class="mx-auto max-w-7xl px-4 py-4">
		<div class="w-full flex flex-col gap-4 sm:flex-row">
			<div class="w-[500px] flex flex-col gap-3">
				{{-- Best Records --}}
				<div class="w-full flex justify-center">
					<x-dashboard.best-record
						:day-count="$best_record['day_count']"
						:last-day="$best_record['last_day']"
					/>
				</div>
				<!-- Line Performance -->
				<div class="mt-4 w-full flex flex-col">
					<x-dashboard.line-performance
						:items="$linePerformances"
					/>
				</div>
			</div>
			{{-- Carousel Panel --}}
			<div class="w-full">
				@auth
				<div class="h-[515px] bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 flex flex-col">
					{{-- Carousel Header --}}
					<div class="flex items-center justify-between px-4 py-2.5 bg-sky-200 shrink-0">
						{{-- Slide Tabs --}}
						<div class="flex gap-2" id="carousel-tabs">
							<button onclick="carouselGoTo(0)"
								id="tab-0"
								class="carousel-tab flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 bg-sky-300/50 text-sky-900 hover:bg-sky-300/80">
								<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18"/></svg>
								Data Table
							</button>
							<button onclick="carouselGoTo(1)"
								id="tab-1"
								class="carousel-tab flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 bg-sky-100/30 text-sky-700/70 hover:bg-sky-300/50 hover:text-sky-900">
								<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
								Cycle Time Chart
							</button>
						</div>
						{{-- Controls: Dots + Prev/Next + Auto-slide toggle --}}
						<div class="flex items-center gap-3">
							<div class="flex items-center gap-1.5" id="carousel-dots">
								<button onclick="carouselGoTo(0)" id="dot-0" class="carousel-dot w-2 h-2 rounded-full transition-all duration-300 bg-sky-700"></button>
								<button onclick="carouselGoTo(1)" id="dot-1" class="carousel-dot w-2 h-2 rounded-full transition-all duration-300 bg-sky-300"></button>
							</div>
							<button id="carousel-prev-btn" class="w-7 h-7 rounded-full bg-sky-300/50 hover:bg-sky-300 flex items-center justify-center transition-all duration-200 text-sky-900">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m15 19-7-7 7-7"/></svg>
							</button>
							<button id="carousel-next-btn" class="w-7 h-7 rounded-full bg-sky-300/50 hover:bg-sky-300 flex items-center justify-center transition-all duration-200 text-sky-900">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m9 5 7 7-7 7"/></svg>
							</button>
							{{-- Auto-slide Toggle --}}
							<button id="carousel-autoslide-btn" title="Auto Slide"
								class="w-7 h-7 rounded-full bg-sky-300/50 hover:bg-sky-300 flex items-center justify-center transition-all duration-200 text-sky-900">
								{{-- Play icon (default) --}}
								<svg id="icon-play" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
								{{-- Pause icon (hidden by default) --}}
								<svg id="icon-pause" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
							</button>
						</div>
					</div>
				@else
				{{-- Guest: no header, blue top border --}}
				<div class="h-[515px] bg-white shadow-xl rounded-2xl overflow-hidden border-t-4 border-t-sky-200 border border-gray-100 flex flex-col">
				@endauth
					{{-- Slides Wrapper --}}
					<div class="relative flex-1 overflow-hidden" id="carousel-slides-wrapper">
						{{-- Slide 0: Data Table --}}
						<div class="carousel-slide absolute inset-0 transition-all duration-500 ease-in-out opacity-100 translate-x-0 h-full overflow-auto p-3" data-slide="0">
							@include('dashboards.partials.product-table', ['products' => $products])
						</div>
						{{-- Slide 1: Cycle Time Chart --}}
						<div class="carousel-slide absolute inset-0 transition-all duration-500 ease-in-out opacity-0 translate-x-full h-full overflow-auto p-3" data-slide="1">
							<form id="pattern-form" method="POST" action="{{ route('pattern-histories.store') }}" class="flex gap-3 items-center flex-wrap mb-3">
								@csrf
								<input type="hidden" name="line_id" value="{{ $dashboardLineId }}">
								<select name="pattern" class="bg-gray-50 border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg focus:ring-sky-400 focus:border-sky-400 block p-2.5 transition">
									@foreach ($patterns as $pattern)
										<option value="{{ $pattern->id }}" {{ $patternId == $pattern->id ? 'selected' : '' }}>
											{{ $pattern->name }}
										</option>
									@endforeach
								</select>
								<button type="submit" class="bg-gradient-to-r from-red-600 to-rose-900 text-white font-bold text-sm px-5 py-2.5 rounded-lg hover:brightness-110 transition shadow-sm shadow-red-300">APPLY</button>
							</form>
							<div class="bg-gray-50 rounded-xl p-3 h-[430px]">
								<canvas id="chart_main"></canvas>
							</div>
						</div>
					</div>
				</div>
				</div> {{-- end .h-[515px] --}}
			</div>
			{{-- Custom Carousel JS --}}
			<script>
				(function() {
				const slides       = document.querySelectorAll('.carousel-slide');
				const tabs         = document.querySelectorAll('.carousel-tab');
				const dots         = document.querySelectorAll('.carousel-dot');
				const autoBtn      = document.getElementById('carousel-autoslide-btn');
				const iconPlay     = document.getElementById('icon-play');
				const iconPause    = document.getElementById('icon-pause');
				const INTERVAL     = 15000;
				const LS_SLIDE     = 'carousel_slide';
				const LS_AUTO      = 'carousel_auto';

				// Restore from localStorage
				let current   = parseInt(localStorage.getItem(LS_SLIDE) || '0');
				let autoSlide = null;

				window.carouselGoTo = function(index) {
					current = index;
					localStorage.setItem(LS_SLIDE, index);

					slides.forEach((slide, i) => {
						if (i === current) {
							slide.classList.remove('opacity-0', 'translate-x-full', '-translate-x-full');
							slide.classList.add('opacity-100', 'translate-x-0');
						} else {
							slide.classList.remove('opacity-100', 'translate-x-0');
							slide.classList.add('opacity-0', i < current ? '-translate-x-full' : 'translate-x-full');
						}
					});

					// Update tabs
					tabs.forEach((tab, i) => {
						if (i === current) {
							tab.classList.add('bg-sky-300/50', 'text-sky-900');
							tab.classList.remove('bg-sky-100/30', 'text-sky-700/70');
						} else {
							tab.classList.remove('bg-sky-300/50', 'text-sky-900');
							tab.classList.add('bg-sky-100/30', 'text-sky-700/70');
						}
					});

					// Update dots
					dots.forEach((dot, i) => {
						if (i === current) {
							dot.classList.add('bg-sky-700', 'w-4');
							dot.classList.remove('bg-sky-300', 'w-2');
						} else {
							dot.classList.remove('bg-sky-700', 'w-4');
							dot.classList.add('bg-sky-300', 'w-2');
						}
					});

					if (index === 1 && typeof chart_main !== 'undefined' && chart_main) {
						setTimeout(() => {
							chart_main.resize();
						}, 500);
					}
				};

				document.getElementById('carousel-prev-btn')?.addEventListener('click', () => {
					carouselGoTo(current === 0 ? slides.length - 1 : current - 1);
				});
				document.getElementById('carousel-next-btn')?.addEventListener('click', () => {
					carouselGoTo(current === slides.length - 1 ? 0 : current + 1);
				});

				// Auto-slide helpers
				function startAutoSlide() {
					if (autoSlide) return;
					autoSlide = setInterval(() => {
						carouselGoTo(current === slides.length - 1 ? 0 : current + 1);
					}, INTERVAL);
					localStorage.setItem(LS_AUTO, '1');
					if (iconPlay)  iconPlay.classList.add('hidden');
					if (iconPause) iconPause.classList.remove('hidden');
					if (autoBtn)   autoBtn.classList.add('bg-sky-400/60');
				}

				function stopAutoSlide() {
					clearInterval(autoSlide);
					autoSlide = null;
					localStorage.setItem(LS_AUTO, '0');
					if (iconPlay)  iconPlay.classList.remove('hidden');
					if (iconPause) iconPause.classList.add('hidden');
					if (autoBtn)   autoBtn.classList.remove('bg-sky-400/60');
				}

				autoBtn?.addEventListener('click', () => {
					autoSlide ? stopAutoSlide() : startAutoSlide();
				});

				// Init: restore state
				carouselGoTo(current);
				if (localStorage.getItem(LS_AUTO) === '1') {
					startAutoSlide();
				}
			})();
			</script>
		</div>

		<footer class="relative">
			<div class="container mx-auto px-4 pt-1">
				<div class="flex flex-wrap items-center md:justify-between justify-center">
					<div class="w-full md:w-6/12 px-4 mx-auto text-center">
						<div class="text-base text-gray-500  py-1">Dibuat dengan
							<span class="text-gray-900">IKHLAS</span> by
							<span class="text-red-700">b&</span>
						</div>
					</div>
				</div>
			</div>
		</footer> 
		<marquee
			behavior="scroll"
			direction="left"
			scrollamount="15"
			class="fixed bottom-0 left-0 p-1 bg-[#fff333] text-2xl text-red-500">
			{{ $marqueeText->text }}
		</marquee>
		@auth
			<x-ui.modal id="profile-modal" maxWidth="max-w-md">
				<x-ui.profile-card
					:name="Auth::user()->name"
					:email="Auth::user()->email"
					:verified="Auth::user()->email_verified_at !== null"
					:npk="Auth::user()->npk"
					:image="Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/profile-blank.jpg')"
				/>
			</x-ui.modal>

			@if(!$selectedLineId)
				<x-line-select-modal :lines="$lines" />

				<script>
					document.addEventListener('DOMContentLoaded', function () {
						window.Modal?.open('line-select-modal');
					});
				</script>
			@endif
		@endauth
		<x-ui.modal id="login-modal" maxWidth="max-w-3xl">
			<x-auth.login-form />
		</x-ui.modal>
	<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
	<script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>

	<script> // Main Chart

        let chart_main    = null;
		let chartRendered = false;

		// DATA (nanti dari backend / AJAX)
		const tactTime     = 20;
		const dataAverage  = @json(array_map(fn($v) => round($v, 2), $cycleTimeData['average'] ?? []));
		const dataMax      = @json(array_map(fn($v) => round($v, 2), $cycleTimeData['max'] ?? []));
		const dataMin      = @json(array_map(fn($v) => round($v, 2), $cycleTimeData['min'] ?? []));
		const paretoLabels = @json($cycleTimeData['sensor'] ?? []);
		const maxY         = {{ $cycleTimeData['maxY'] ?? 100 }};

		const bgColors = dataAverage.map(v =>
			v > tactTime ? 'rgba(239, 68, 68, 0.5)' : 'rgba(14, 165, 233, 0.5)'
		);
		const bdColors = dataAverage.map(v =>
			v > tactTime ? 'rgba(239, 68, 68, 1)' : 'rgba(14, 165, 233, 1)'
		);

		// annotation
		const verticalAnnotations = {};
		paretoLabels.forEach((_, i) => {
			const label = 'POS ' + (i + 1);

			verticalAnnotations['v_' + i] = {
				type: 'line',
				xMin: label,
				xMax: label,
				yMin: dataMin[i],
				yMax: dataMax[i],
				borderColor: 'rgba(54,162,235,1)',
				borderWidth: 2,
				borderDash: [5,5]
			};
		});

        // Fungsi untuk merender ulang chart dengan data baru
        function renderParetoChart(data) {
            if (!chart_main) return;

            const bgColors = data.mainAverages.map(v => v > data.tactTime ? 'rgba(239, 68, 68, 0.5)' : 'rgba(14, 165, 233, 0.5)');
            const bdColors = data.mainAverages.map(v => v > data.tactTime ? 'rgba(239, 68, 68, 1)' : 'rgba(14, 165, 233, 1)');

            chart_main.data.labels                      = data.mainLabels.map((name, index) => 'POS ' + (index + 1));
            chart_main.data.datasets[0].data            = data.mainAverages.map(v => parseFloat(v).toFixed(1));
            chart_main.data.datasets[0].backgroundColor = bgColors;
            chart_main.data.datasets[0].borderColor     = bdColors;

            chart_main.update();
        }

		function initMainChart() {
			const ctx = document.getElementById('chart_main').getContext('2d');

			chart_main = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: paretoLabels.map((_, i) => 'POS ' + (i + 1)),
					datasets: [{
						label: 'Time (s)',
						data: dataAverage,
						backgroundColor: bgColors,
						borderColor: bdColors,
						borderWidth: 2,
						borderRadius: 4
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					scales: {
						x: {
                            ticks: {
                                font: {
                                    size: 16,
                                    weight: 'normal'
                                },
                                color: '#000'
                            },
                        },
						y: {
							beginAtZero: true,
							max: dataMax.length > 0 ? (Math.max(...dataMax)) : maxY,
							title: {
                                display: true,
                                text: 'Second',
                                font: { size: 12 }
                            },
							ticks: { stepSize: 4 }
						}
					},
					plugins: {
						legend: { display: true },
						tooltip: {
							backgroundColor: '#111827',
							padding: 10,
							titleFont: { size: 12 },
							bodyFont: { size: 12, weight: 'bold' },
							displayColors: false,
							callbacks: {
								label: function(item) {
									return ` Avg: ${item.parsed.y}s`;
								}
							}
						},
						datalabels: {
							display: true,
							color: '#000',
							font: { weight: 'bold', size: 16 },
						},
						annotation: {
							annotations: {
								tactLine: {
									type: 'line',
									yMin: tactTime,
									yMax: tactTime,
									borderColor: 'rgba(239, 68, 68, 1)',
									borderWidth: 2,
									borderDash: [6, 4],
									label: {
										display: true,
										content: 'SCL : ' + tactTime + 's',
										position: 'end',
										backgroundColor: 'rgba(239,68,68,0.85)',
										color: '#fff',
										font: { size: 10, weight: 'bold' },
										padding: { x: 8, y: 4 },
										borderRadius: 6
									}
								},
								...verticalAnnotations
							}
						}
					}
				}
			});
		}

		document.addEventListener('DOMContentLoaded', () => {
			initMainChart();

			// paksa resize setelah layout settle
			setTimeout(() => {
				if (chart_main) {
					chart_main.resize();
				}
			}, 300);
		});
    </script>
	<script> // Handling Modal
		const LinePerformanceModal = {

			// ===== ELEMENT =====
			btnCreate : document.getElementById('line-performance-btn-create'),
			overlay   : document.getElementById('line-performance-modal-overlay'),
			content   : document.getElementById('line-performance-modal-create'),
			form      : document.getElementById('line-performance-form'),
			btnSubmit : document.getElementById('lp-submit'),
			btnDelete : document.getElementById('lp-delete'),
			btnReset  : document.getElementById('lp-reset'),
			inputId   : document.getElementById('lp-id'),

			search    : document.getElementById('lp-search'),
			group     : document.getElementById('lp-group'),
			tbody     : document.getElementById('line-performance-tbody'),

			timer	 : null,

			// ===== OPEN CREATE =====
			open() {
				// Tampilkan overlay & content
				this.overlay.classList.remove('hidden');
				this.content.classList.remove('hidden');

				// 🔥 RESET KE STATE AWAL (WAJIB)
				this.content.classList.add('opacity-0', 'scale-95');
				this.content.classList.remove('opacity-100', 'scale-100');
				this.overlay.classList.add('opacity-0');

				// Force reflow
				void this.content.offsetWidth;

				// 🔥 MULAI ANIMASI MASUK
				this.overlay.classList.remove('opacity-0');
				this.content.classList.remove('opacity-0', 'scale-95');
				this.content.classList.add('opacity-100', 'scale-100');
			},

			// ===== EDIT =====
			edit(id) {
				fetch(`/linePerformance/edit/${id}`)
					.then(res => res.json())
					.then(data => {

						// isi form
						document.getElementById('lp-id').value = id;
						document.getElementById('line-performance-month').value  = data.month;
						document.getElementById('line-performance-year').value   = data.year;
						document.getElementById('line-performance-target').value = data.target;
						document.getElementById('line-performance-actual').value = data.actual;

						// ubah action form ke UPDATE
						this.form.action = `/linePerformance/update/${id}`;

						// method PUT
						if (!document.getElementById('lp-method')) {
							const m = document.createElement('input');
							m.type  = 'hidden';
							m.name  = '_method';
							m.id    = 'lp-method';
							m.value = 'PUT';
							this.form.appendChild(m);
						}

						// tombol
						this.btnSubmit.textContent = 'Save';
						this.btnDelete?.classList.remove('hidden');
						this.btnReset.classList.remove('hidden');

						// scroll ke form
						form.scrollIntoView({ behavior: 'smooth' });
					});
			},

			// ===== DELETE =====
			delete() {
				const id = this.inputId.value;
				if (!id || !confirm('Delete this data?')) return;

				fetch(`/linePerformance/destroy/${id}`, {
					method: 'DELETE',
					headers: {
						'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
					}
				}).then(() => location.reload());
			},

			reset() {
				this.form.reset();
				this.form.action = "{{ route('line-performance.store') }}";

				document.getElementById('lp-method')?.remove();
				this.inputId.value = '';

				this.btnSubmit.textContent = 'Submit';
				this.btnDelete.classList.add('hidden');
				this.btnReset.classList.add('hidden');
			},


			// ===== CLOSE =====
			close() {
				// Animasi keluar content
				this.content.classList.remove('opacity-100', 'scale-100');
				this.content.classList.add('opacity-0', 'scale-95');

				// Animasi overlay
				this.overlay.classList.add('opacity-0');

				setTimeout(() => {
					// Sembunyikan semuanya
					this.content.classList.add('hidden');
					this.overlay.classList.add('hidden');

					// Reset class
					this.content.classList.remove('opacity-0', 'scale-95');
					this.overlay.classList.remove('opacity-0');
				}, 300);
			},

			/* ===============================
			TABLE
			================================ */
			loadData() {
				const q     = this.search.value;
				const group = this.group.value;

				fetch(`/linePerformance/search?q=${q}&group=${group}`)
					.then(r => r.json())
					.then(d => this.renderTable(d, group));
			},

			renderTable(data, group) {
				this.tbody.innerHTML = '';

				data.forEach(row => {
					const grouped = group !== '';

					this.tbody.innerHTML += `
						<tr class="border-b">
							<td>${row.month ?? '-'}</td>
							<td>${row.year ?? '-'}</td>
							<td>${row.target}</td>
							<td>${row.actual}</td>
							<td>
								${!grouped && row.id
									? `<button onclick="LinePerformanceModal.edit(${row.id})"
										class="text-blue-600 hover:underline">Edit</button>`
									: `<span class="text-gray-400">-</span>`
								}
							</td>
						</tr>
					`;
				});
			},

			// ===== BIND =====
			bind() {
				this.btnCreate?.addEventListener('click', () => this.open());
				this.btnDelete?.addEventListener('click', () => this.delete());
    			this.btnReset?.addEventListener('click', () => this.reset());

				this.overlay?.addEventListener('click', (e) => {
					if (e.target === this.overlay) this.close();
				});

				this.search?.addEventListener('input', () => {
					clearTimeout(this.timer);
					this.timer = setTimeout(() => this.loadData(), 300);
				});

				this.group?.addEventListener('change', () => this.loadData());
			}
		};

		// INIT
		document.addEventListener('DOMContentLoaded', () => {
			LinePerformanceModal.bind();
			LinePerformanceModal.loadData();
		});
	</script>
	<script>
		document.addEventListener('click', function (e) {

			// hanya tangkap pagination link
			if (e.target.tagName === 'A' && e.target.closest('#line-performance-pagination')) {
				e.preventDefault();

				const url = e.target.getAttribute('href');
				if (!url) return;

				fetch(url, {
					headers: { 'X-Requested-With': 'XMLHttpRequest' }
				})
				.then(res => res.text())
				.then(html => {

					// parse HTML response
					const parser = new DOMParser();
					const doc = parser.parseFromString(html, 'text/html');

					// replace table
					const newTable = doc.getElementById('line-performance-table-wrapper');
					document.getElementById('line-performance-table-wrapper').innerHTML =
						newTable.innerHTML;

					// replace pagination
					const newPagination = doc.getElementById('line-performance-pagination');
					document.getElementById('line-performance-pagination').innerHTML =
						newPagination.innerHTML;
				});
			}

		});
	</script>
	<script>
		document.getElementById('animate-marquee')?.addEventListener('blur', function() {
			let newText = this.innerText;
			fetch("{{ route('marqueeText.update') }}", {
				method: "POST",
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				body: JSON.stringify({ text: newText })
			})
			.then(response => response.json())
			.then(data => {
				console.log(data);
				if (data.success) {
					alert(data.message);
					document.activeElement.blur();
				} else {
					alert('Gagal memperbarui teks.');
				}
			})
			.catch(error => console.error('Error:', error));
		});
	</script>
	<script> // Date and Time Display
		// Fungsi untuk memperbarui waktu setiap detik
		function clock() {
			const now 		 = new Date();
			const hours 	 = String(now.getHours()).padStart(2, '0');
			const minutes 	 = String(now.getMinutes()).padStart(2, '0');
			const seconds 	 = String(now.getSeconds()).padStart(2, '0');
			const timeString = `${hours}:${minutes}:${seconds}`;

			// Format tanggal (dd/mm/yyyy)
			const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
			const dateString = now.toLocaleDateString('id-ID', options);

			document.getElementById("current-time").textContent = timeString;
			document.getElementById("current-date").textContent = dateString;
		}

		// Panggil fungsi updateClock setiap 1 detik
		setInterval(clock, 1000);
		clock(); // Panggil segera saat halaman dimuat
	</script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {

			const labels           = @json($labels);
			const actualData       = @json($actual);
			const minusOeeData     = @json($minusOee);
			const allowedTimeData  = @json($allowedTime);

			const canvas = document.getElementById('stackedBarChart');

			if (!canvas) {
				console.error('Canvas stackedBarChart tidak ditemukan');
				return;
			}

			Chart.register(ChartDataLabels);

			new Chart(canvas, {
				type: 'bar',
				data: {
					labels: labels,
					datasets: [
						{
							label: 'OEE',
							data: actualData,
							backgroundColor: '#2196F3',
							datalabels: {
								display: true,
								anchor: 'center',
								align: 'center',
								color: '#fff',
								font: {
									weight: 'bold',
									size: 16
								},
								formatter: (value) => value + '%'
							}
						},
						{
							label: 'Minus OEE',
							data: minusOeeData,
							backgroundColor: '#FF0000',
							datalabels: {
								display: false
							}
						},
						{
							label: 'Allowed Time',
							data: allowedTimeData,
							backgroundColor: '#4CAF50',
							datalabels: {
								display: false
							}
						}
					]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							position: 'top'
						}
					},
					scales: {
						x: {
							stacked: true
						},
						y: {
							stacked: true,
							beginAtZero: true,
							max: 120,
							title: {
								display: true,
								text: '%'
							}
						}
					}
				},
				plugins: [ChartDataLabels]
			});

		});
	</script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {

			setInterval(function () {

				fetch('{{ route("products.fetchTable") }}', {
					headers: {
						'X-Requested-With': 'XMLHttpRequest'
					}
				})
				.then(res => res.text())
				.then(html => {
					document.getElementById('tampil').innerHTML = html;
				})
				.catch(err => console.error('Auto refresh error:', err));

			}, 10000);

		});
	</script>
	<style>
		@keyframes marquee {
		from { transform: translateX(100%); }
		to { transform: translateX(-100%); }
		}
		.animate-marquee {
		display: inline-block;
		animation: marquee 15s linear infinite;
		white-space: nowrap; /* Menghindari pemotongan teks */
		}
	</style>
	<script>
		document.getElementById('marqueeText')?.addEventListener('click', function() {
		// Fokuskan elemen untuk mempermudah pengeditan
		this.focus();
		});
	</script>
	<script>CKEDITOR.replace('animate-marquee');</script>
	<script>
		//message with sweetalert
		@if(session('success'))
			Swal.fire({
				icon: "success",
				title: "BERHASIL",
				text: "{{ session('success') }}",
				showConfirmButton: false,
				timer: 2000
			});
		@elseif(session('error'))
			Swal.fire({
				icon: "error",
				title: "GAGAL!",
				text: "{{ session('error') }}",
				showConfirmButton: false,
				timer: 2000
			});
		@endif
	</script>
	<script>
		document.addEventListener('DOMContentLoaded', () => {

			console.log('AUTO REFRESH ACTIVE');

			setInterval(() => {
				console.log('FETCHING...');

				fetch('{{ route("products.fetchTable") }}')
					.then(res => res.text())
					.then(html => {
						const el = document.getElementById('tampil');
						if (!el) {
							console.error('#tampil tidak ditemukan');
							return;
						}
						el.innerHTML = html;
					})
					.catch(err => console.error(err));

			}, 10000);

		});
	</script>
@endsection