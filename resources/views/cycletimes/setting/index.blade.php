@extends('layouts.system-manager')

@section('content')
<div x-data="{ isAddModalOpen: false, editModalOpen: null }" class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Settings Image --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/setting.jpg') }}" alt="Cycle Time Settings" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
            </div>
            {{-- Decorative Right Background --}}
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-red-50 to-transparent z-20"></div>
            {{-- Decorative Glow Circle --}}
            <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-red-500/10 blur-3xl z-30"></div>
            {{-- Decorative Small Circle --}}
            <div class="absolute right-20 top-1/2 -translate-y-1/2 w-24 h-24 rounded-full bg-red-100/50 z-30"></div>
            {{-- Content --}}
            <div class="relative z-40 px-8 py-5 pl-[380px] min-h-[140px] flex flex-col justify-center">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">CYCLE TIME SETTINGS</h1>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    Configure operating modes and patterns for the
                    <span class="font-semibold text-red-600">AISS cycle time</span> monitoring module.
                </p>
            </div>
        </div>

        {{-- ===== SYSTEM MESSAGES ===== --}}
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm relative">
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terdapat kesalahan pengisian form:</h3>
                        <div class="mt-1 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-5 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm relative">
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-green-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== SENSOR MAPPING PLACEHOLDER ===== --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Sensor Mapping Layout</h2>
                    <p class="text-sm text-gray-500 mt-1">Visual map showing the position of sensors on the production line.</p>
                </div>
                {{-- Upload form --}}
                <form action="{{ route('cycletimes.setting.upload-map') }}" method="POST" enctype="multipart/form-data" id="map-upload-form">
                    @csrf
                    <input type="file" name="map_image" id="map_image_input" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="document.getElementById('map-upload-form').submit()">
                    <button type="button" onclick="document.getElementById('map_image_input').click()" class="flex items-center gap-2 px-3 py-1.5 text-sm font-semibold text-rose-600 bg-rose-50 rounded-lg hover:bg-rose-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload Map
                    </button>
                </form>
            </div>
            
            <div class="w-full min-h-[300px] bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 group hover:border-red-300 hover:bg-red-50/30 transition-all cursor-pointer overflow-hidden relative" onclick="document.getElementById('map_image_input').click()">
                @if(file_exists(public_path('img/sensor-mapping.png')))
                    <img src="{{ asset('img/sensor-mapping.png') }}?v={{ time() }}" class="w-full h-auto object-contain p-2" alt="Sensor Map">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-white font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Change Map Image
                        </span>
                    </div>
                @else
                    <svg class="w-10 h-10 mb-2 text-gray-300 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium group-hover:text-red-500 transition-colors">Click here to upload Sensor Map</span>
                    <span class="text-xs text-gray-400 mt-1">Recommended size: 1200x500px, formats: JPG, PNG, WEBP</span>
                @endif
            </div>
        </div>

        {{-- ===== DATA TABLE & ACTION ===== --}}
        <div>
            <div class="flex items-end justify-between mb-3">
                <div>
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Configuration</p>
                    <h2 class="text-xl font-bold text-gray-900">Registered Patterns</h2>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="isAddModalOpen = true" id="add-modal-btn" class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-red-600 to-rose-700 rounded-lg shadow-sm shadow-red-200 hover:brightness-110 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Add Pattern</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Search bar --}}
                <div class="p-4 border-b border-gray-100">
                    <form id="pattern-search-form" class="flex items-center gap-2">
                        <div class="relative flex-1 max-w-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search" id="simple-search"
                                   placeholder="Search patterns..."
                                   class="block w-full pl-9 pr-4 py-2 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition"/>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase">Pattern Name</th>
                                @foreach ($sensors as $sensor)
                                    <th class="px-3 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase text-center w-16" title="{{$sensor->name}}">{{$sensor->id}}</th>
                                @endforeach
                                <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase text-center">Cycle/Tact</th>
                                <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase text-center">Threshold (Min-Max)</th>
                                <th class="px-5 py-3 text-[10px] font-bold tracking-widest text-gray-400 uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($patterns as $index => $pattern)
                                <tr class="hover:bg-red-50/40 transition-colors duration-150 group">
                                    {{-- Pattern Name --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="font-semibold text-gray-800 text-sm flex items-center gap-2.5">
                                            <div class="w-2.5 h-2.5 rounded-full bg-red-500 shadow-sm shadow-red-200"></div>
                                            {{ $pattern->name }}
                                        </div>
                                    </td>
                                    
                                    {{-- Sensors --}}
                                    @foreach ($sensors as $sensor)
                                        @php
                                            $activeSensor = $pattern->sensors->firstWhere('id', $sensor->id);
                                        @endphp
                                        <td class="px-3 py-4 text-center">
                                            @if($activeSensor)
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-sky-100 text-sky-600 font-bold text-xs" title="Pos {{ $activeSensor->pivot->pos }}">
                                                        {{ $activeSensor->pivot->pos }}
                                                    </span>
                                                    <span class="text-[10px] text-gray-500" title="Barang per pembacaan">Cycle {{ $activeSensor->pivot->cycle }}</span>
                                                </div>
                                            @else
                                                <div class="flex justify-center">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-300" title="Off">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach

                                    {{-- Timing --}}
                                    <td class="px-5 py-4 text-center font-mono text-gray-700 bg-gray-50/30">
                                        {{ $pattern->cycle_time }}<span class="text-xs text-gray-400">s</span>
                                    </td>
                                    <td class="px-5 py-4 text-center text-gray-500 text-xs">
                                        <span class="font-mono text-gray-700">{{ $pattern->min_time }}</span>s
                                        <span class="mx-1 text-gray-300">—</span>
                                        <span class="font-mono text-gray-700">{{ $pattern->max_time }}</span>s
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                            <button @click="editModalOpen = {{ $pattern->id }}" id="btn-modal-edit-{{ $pattern->id }}" class="w-10 h-7 flex items-center justify-center rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 transition" title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <form action="{{ route('cycletimes.setting.destroy', $pattern->id) ?? '#' }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pattern: {{ $pattern->name }}?')"
                                                    title="Delete"
                                                    class="w-10 h-7 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="px-5 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                            <span class="text-sm">Belum ada data pattern.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    {{-- ===== ADD PATTERN MODAL ===== --}}
    <div x-show="isAddModalOpen" style="display: none"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="isAddModalOpen" x-transition.opacity
                 class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm" aria-hidden="true" @click="isAddModalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="isAddModalOpen"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block px-1 pt-1 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6 border border-gray-100">
                
                <form action="{{ route('cycletimes.setting.store') }}" method="POST">
                    @csrf
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Add New Pattern</h3>
                            <div class="mt-5 space-y-4">
                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pattern Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" required class="w-full text-sm rounded-xl border-gray-200 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="e.g. DAY-SHIFT-PATTERN">
                                </div>
                                {{-- Sensors --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sensor Positions</label>
                                    <p class="mb-2 text-xs text-gray-500">Cycle adalah jumlah barang dalam satu pembacaan; durasi akan dibagi nilai Cycle.</p>
                                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($sensors as $s)
                                            <div class="flex items-center justify-between p-2 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                                                <span class="ml-2 text-sm font-medium text-gray-700">{{ $s->name }}</span>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <label class="text-[10px] text-gray-500">Pos
                                                        <input type="number" name="sensors[{{ $s->id }}][pos]" min="1" class="w-14 h-8 text-sm text-center border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500" placeholder="1">
                                                    </label>
                                                    <label class="text-[10px] text-gray-500">Cycle
                                                        <input type="number" name="sensors[{{ $s->id }}][cycle]" min="1" value="1" class="w-14 h-8 text-sm text-center border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500" title="Jumlah barang per pembacaan">
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- Timings --}}
                                <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Target Cycle <span class="text-gray-400 text-xs font-normal">(sec)</span></label>
                                        <input type="number" name="cycle_time" required step="0.1" min="0" class="w-full text-sm font-mono rounded-xl border-gray-200 focus:ring-red-500 focus:border-red-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Min Threshold</label>
                                        <input type="number" name="min_time" required step="0.1" min="0" class="w-full text-sm font-mono rounded-xl border-gray-200 focus:ring-red-500 focus:border-red-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Max Threshold</label>
                                        <input type="number" name="max_time" required step="0.1" min="0" class="w-full text-sm font-mono rounded-xl border-gray-200 focus:ring-red-500 focus:border-red-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-8 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none sm:w-auto sm:text-sm transition-colors">
                            Save Pattern
                        </button>
                        <button type="button" @click="isAddModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 px-4 py-2 shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== EDIT PATTERN MODALS ===== --}}
    @foreach($patterns as $pattern)
    <div x-show="editModalOpen === {{ $pattern->id }}" style="display: none"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="editModalOpen === {{ $pattern->id }}" x-transition.opacity
                 class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm" aria-hidden="true" @click="editModalOpen = null"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="editModalOpen === {{ $pattern->id }}"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block px-1 pt-1 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6 border border-gray-100">
                
                <form action="{{ route('cycletimes.setting.update', $pattern->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-sky-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Edit Pattern</h3>
                            <div class="mt-5 space-y-4">
                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pattern Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ $pattern->name }}" required class="w-full text-sm rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500 transition-colors">
                                </div>
                                {{-- Sensors --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sensor Positions</label>
                                    <p class="mb-2 text-xs text-gray-500">Cycle adalah jumlah barang dalam satu pembacaan; durasi akan dibagi nilai Cycle.</p>
                                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($sensors as $s)
                                            @php 
                                                $activeSensor = $pattern->sensors->firstWhere('id', $s->id); 
                                                $posValue = $activeSensor ? $activeSensor->pivot->pos : '';
                                                $cycleValue = $activeSensor ? $activeSensor->pivot->cycle : 1;
                                            @endphp
                                            <div class="flex items-center justify-between p-2 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                                                <span class="ml-2 text-sm font-medium text-gray-700">{{ $s->name }}</span>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <label class="text-[10px] text-gray-500">Pos
                                                        <input type="number" name="sensors[{{ $s->id }}][pos]" value="{{ $posValue }}" min="1" class="w-14 h-8 text-sm text-center border-gray-300 rounded-md focus:ring-sky-500 focus:border-sky-500" placeholder="1">
                                                    </label>
                                                    <label class="text-[10px] text-gray-500">Cycle
                                                        <input type="number" name="sensors[{{ $s->id }}][cycle]" value="{{ $cycleValue }}" min="1" class="w-14 h-8 text-sm text-center border-gray-300 rounded-md focus:ring-sky-500 focus:border-sky-500" title="Jumlah barang per pembacaan">
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- Timings --}}
                                <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Target Cycle <span class="text-gray-400 text-xs font-normal">(sec)</span></label>
                                        <input type="number" name="cycle_time" value="{{ $pattern->cycle_time }}" required step="0.1" min="0" class="w-full text-sm font-mono rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Min Threshold</label>
                                        <input type="number" name="min_time" value="{{ $pattern->min_time }}" required step="0.1" min="0" class="w-full text-sm font-mono rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Max Threshold</label>
                                        <input type="number" name="max_time" value="{{ $pattern->max_time }}" required step="0.1" min="0" class="w-full text-sm font-mono rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-8 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-4 py-2 shadow-sm text-base font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none sm:w-auto sm:text-sm transition-colors">
                            Update Pattern
                        </button>
                        <button type="button" @click="editModalOpen = null" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 px-4 py-2 shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <x-ui.footer />
</div>

@endsection
