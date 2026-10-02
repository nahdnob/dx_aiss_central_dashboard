@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">
        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Decorative Background --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/performance.jpg') }}" class="w-full h-full object-cover" alt="Risk Assessment">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-white"></div>
            </div>
            {{-- Decorative Right Background --}}
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-red-50 to-transparent z-20"></div>
            {{-- Decorative Glow Circle --}}
            <div class="absolute right-12 top-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-red-500/10 blur-3xl z-30"></div>
            {{-- Decorative Small Circle ----}}
            <div class="absolute right-20 top-1/2 -translate-y-1/2 w-24 h-24 rounded-full bg-red-100/50 z-30"></div>
            {{-- Content --}}
            <div class="relative z-40 px-8 py-5 pl-[380px] min-h-[140px] flex flex-col justify-center">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">RISK ASSESSMENT</h1>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    Manage Risk Assessment documents for the AISS production system.
                    <span class="font-semibold text-red-600">Add hazard analysis, edit, and track revisions</span>.
                </p>
            </div>
        </div>

        {{-- ===== FORM OPERATION INPUT ===== --}}
        <div class="mb-6">
            {{-- Title --}}
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Operations Input</p>
                <h2 class="text-xl font-bold text-gray-900">New Risk Assessment</h2>
            </div>
            {{-- Form --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <form action="{{ route('risk-assessments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3 items-end">
                        <!-- Input RA Name -->
                        <div class="flex-1 min-w-0">
                            <label for="name" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Name</label>
                            <input class="w-full border border-gray-200 placeholder:text-gray-400 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="text"
                                name        ="name"
                                id          ="name"
                                placeholder ="e.g., RA Machine..."
                                required>
                        </div>
                        <!-- Input RA No -->
                        <div class="flex-1 min-w-0">
                            <label for="ra_no" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">RA No</label>
                            <input class="w-full border border-gray-200 placeholder:text-gray-400 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="text"
                                name        ="ra_no"
                                id          ="ra_no"
                                placeholder ="e.g., RA-123..."
                                required>
                        </div>
                        <!-- Input RA Level -->
                        <div class="flex-1 min-w-0">
                            <label for="ra_level" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">RA Level</label>
                            <input class="w-full border border-gray-200 placeholder:text-gray-400 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="number"
                                name        ="ra_level"
                                id          ="ra_level"
                                min         ="1"
                                max         ="4"
                                placeholder ="1 - 4">
                        </div>
                        <!-- Input Security Rank -->
                        <div class="flex-1 min-w-0">
                            <label for="ra_security_rank" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Security Rank</label>
                            <select name="ra_security_rank" id="ra_security_rank" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                                <option value="">Select Rank</option>
                                <option value="A">A: Work does not depend of human</option>
                                <option value="C">C: Work depends of human</option>
                                <option value="E">E: Work with SOP without RA</option>
                            </select>
                        </div>
                        <!-- Input RA File -->
                        <div class="flex-1 min-w-0 w-full">
                            <label for="ra_file" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Choose File</label>
                            <div class="flex items-center gap-3 border border-gray-200 rounded-lg px-1.5 py-1.5 bg-gray-50 hover:border-gray-300 transition">
                                <button type="button" id="raFileButton" class="shrink-0 px-4 py-1.5 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 font-semibold text-xs rounded-lg transition whitespace-nowrap shadow-sm">Browse File</button>
                                <span id="raFileName" class="text-sm text-gray-500 flex-1 truncate">No file selected</span>
                                <input class="hidden"
                                    type   ="file"
                                    name   ="ra_file"
                                    id     ="ra_file"
                                    accept =".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx"
                                    required>
                            </div>
                        </div>
                        <div class="shrink-0 w-full sm:w-auto">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:brightness-110 text-white font-bold text-sm px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200 whitespace-nowrap uppercase">
                                Add
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== DATA TABLE ===== --}}
        <div class="mb-6">
            <div class="flex items-end justify-between mb-3">
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Data</p>
                    <h2 class="text-xl font-bold text-gray-900">Risk Assessment Documents</h2>
                </div>
            </div>
            {{-- Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Search bar --}}
                <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form id="ra-search-form" method="GET" action="{{ route('risk-assessments.index') }}" class="flex items-center gap-2 flex-1 max-w-lg">
                        {{-- Search Input --}}
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input class="placeholder:text-gray-400 block w-full pl-9 pr-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                type        ="search"
                                id          ="search"
                                name        ="search"
                                value       ="{{ request('search') }}"
                                placeholder ="Search title, document number...">
                        </div>
                        {{-- Button Search --}}
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">Search</button>
                        {{-- Button Reset --}}
                        @if(request('search'))
                            <a href="{{ route('risk-assessments.index') }}" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition shrink-0 uppercase">Reset</a>
                        @endif
                    </form>
                </div>
                <table class="w-full text-sm text-left">
                    {{-- Table Header --}}
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-150 text-center text-gray-500 font-bold text-[10px] tracking-widest uppercase">
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">RA No</th>
                            <th class="px-5 py-3">RA Level</th>
                            <th class="px-5 py-3">Security Rank</th>
                            <th class="px-5 py-3">RA File</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($riskAssessments as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                                <!-- Name -->
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-gray-900 text-sm">{{ $item->name }}</div>
                                </td>
                                <!-- RA No -->
                                <td class="px-5 py-4 text-center">
                                    <div class="text-sm text-gray-600 font-mono">{{ $item->ra_no }}</div>
                                </td>
                                <!-- RA Level -->
                                <td class="px-5 py-4 text-center">
                                    <div class="text-sm text-gray-600 font-mono">{{ $item->ra_level ?? '-' }}</div>
                                </td>
                                <!-- Security Rank -->
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200 font-mono">
                                        {{ $item->ra_security_rank ?? '-' }}
                                    </span>
                                </td>
                                <!-- Revision -->
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-bold bg-slate-400 text-white">
                                        {{ $item->revision }}
                                    </span>
                                </td>
                                <!-- RA File -->
                                <td class="px-5 py-4 text-center">
                                    @if($item->link)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($item->link) }}" target="_blank" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-800 break-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            Open File
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">No file</span>
                                    @endif
                                </td>
                                <!-- Actions -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                            <a class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-500 text-white hover:bg-sky-600 transition shadow-sm"
                                                href="javascript:void(0)"
                                                data-modal-open="edit-ra-modal-{{ $item->id }}"
                                                title="Edit"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('risk-assessments.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this document?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 transition shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-gray-400 text-sm">No Risk Assessment documents yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- ===== EDIT MODALS ===== --}}
                @foreach ($riskAssessments as $item)
                    <x-ui.modal id="edit-ra-modal-{{ $item->id }}">
                        <div class="w-full bg-white rounded-2xl shadow-2xl flex flex-col mx-auto" style="width: 580px; max-width: 95vw; max-height: 90vh;">
                            {{-- Modal Header --}}
                            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-sky-50 to-white shrink-0 rounded-t-2xl">
                                <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-sky-100 shrink-0">
                                    <svg class="text-sky-600" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-bold text-gray-900 leading-tight">Edit Risk Assessment</h3>
                                    <p class="text-xs text-gray-400 mt-0.5">Update the Risk Assessment details below and save changes.</p>
                                </div>
                                <button type="button" data-modal-close="edit-ra-modal-{{ $item->id }}"
                                    class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Modal Body (scrollable) --}}
                                            <form action="{{ route('risk-assessments.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                                @csrf
                                @method('PUT')
                                <div class="px-6 py-5 space-y-4 overflow-y-auto flex-1 text-left">
                                    <div>
                                        <label for="edit_name_{{ $item->id }}" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">Document Name</label>
                                        <input type="text" name="name" id="edit_name_{{ $item->id }}" value="{{ $item->name }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition" placeholder="Enter document name">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label for="edit_ra_no_{{ $item->id }}" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">RA No</label>
                                            <input type="text" name="ra_no" id="edit_ra_no_{{ $item->id }}" value="{{ $item->ra_no }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition" placeholder="e.g. RA-001">
                                        </div>
                                        <div>
                                            <label for="edit_ra_level_{{ $item->id }}" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">RA Level</label>
                                            <input type="number" name="ra_level" id="edit_ra_level_{{ $item->id }}" value="{{ $item->ra_level }}" min="1" max="4" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition" placeholder="1 - 4">
                                        </div>
                                        <div>
                                            <label for="edit_ra_security_rank_{{ $item->id }}" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">Security Rank</label>
                                            <select name="ra_security_rank" id="edit_ra_security_rank_{{ $item->id }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                                                <option value="">Select Rank</option>
                                                <option value="A" {{ $item->ra_security_rank == 'A' ? 'selected' : '' }}>A: Work does not depend of human</option>
                                                <option value="C" {{ $item->ra_security_rank == 'C' ? 'selected' : '' }}>C: Work depends of human</option>
                                                <option value="E" {{ $item->ra_security_rank == 'E' ? 'selected' : '' }}>E: Work with SOP without RA</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="edit_revision_{{ $item->id }}" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">Revision</label>
                                            <input type="number" name="revision" id="edit_revision_{{ $item->id }}" value="{{ $item->revision }}" min="1" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">Upload File (Optional)</label>
                                        <div class="flex items-center gap-3 border border-gray-200 rounded-lg px-1.5 py-1.5 bg-white hover:border-gray-300 transition">
                                            <button type="button" class="edit-file-btn shrink-0 px-4 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-lg transition whitespace-nowrap">Browse File</button>
                                            <span class="edit-file-name text-sm text-gray-600 flex-1 truncate">
                                                @if($item->link)
                                                    {{ basename($item->link) }}
                                                @else
                                                    No file selected
                                                @endif
                                            </span>
                                            <input type="file" name="ra_file" accept=".pdf,.doc,.docx,.xlsx,.xls,.ppt,.pptx" class="edit-file-input hidden">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1.5">Line</label>
                                        <select name="line_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                                            <option value="">— No selection —</option>
                                            @foreach($lines as $line)
                                                <option value="{{ $line->id }}" {{ $item->line_id == $line->id ? 'selected' : '' }}>{{ $line->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Modal Footer --}}
                                <div class="flex items-center justify-end gap-2 px-6 py-4 bg-gray-50 border-t border-gray-100 shrink-0 rounded-b-2xl">
                                    <button type="button" data-modal-close="edit-ra-modal-{{ $item->id }}" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">Cancel</button>
                                    <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg hover:brightness-110 shadow-sm transition">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </x-ui.modal>
                @endforeach

                {{-- Pagination --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                    <p class="text-xs text-slate-400 font-medium">
                        Showing {{ $riskAssessments->firstItem() ?? 0 }}–{{ $riskAssessments->lastItem() ?? 0 }} of {{ $riskAssessments->total() }} records
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($riskAssessments->onFirstPage())
                            <span class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $riskAssessments->previousPageUrl() }}" class="px-4 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Previous</a>
                        @endif
                        @if ($riskAssessments->hasMorePages())
                            <a href="{{ $riskAssessments->nextPageUrl() }}" class="px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg hover:brightness-110 shadow-sm transition">Next</a>
                        @else
                            <span class="px-4 py-1.5 text-xs font-bold text-white bg-sky-300 rounded-lg cursor-not-allowed">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-ui.footer />
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ADD FORM — File input
    const raFileButton = document.getElementById('raFileButton');
    const raFileInput  = document.getElementById('ra_file');
    const raFileName   = document.getElementById('raFileName');

    if (raFileButton && raFileInput) {
        raFileButton.addEventListener('click', () => raFileInput.click());
        raFileInput.addEventListener('change', () => {
            raFileName.textContent = raFileInput.files.length > 0 ? raFileInput.files[0].name : 'No file selected';
        });
    }

    // EDIT MODALS — File picker
    document.querySelectorAll('.edit-file-btn').forEach(btn => {
        const wrapper   = btn.closest('.flex.items-center.gap-3');
        const fileInput = wrapper.querySelector('.edit-file-input');
        const label     = wrapper.querySelector('.edit-file-name');

        btn.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => {
            label.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : label.textContent;
        });
    });
});
</script>
@endsection
