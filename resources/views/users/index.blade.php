@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <div class="group relative bg-white rounded-2xl border border-gray-200 shadow-sm mb-6 overflow-hidden">
            {{-- Decorative Background --}}
            <div class="absolute left-0 top-0 h-full w-[420px] z-10">
                <img src="{{ asset('assets/images/performance.jpg') }}" alt="SOP" class="w-full h-full object-cover">
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
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">User Management</h1>
                <p class="mt-2 text-sm text-gray-500 leading-relaxed max-w-2xl">
                    Manage system users and their access roles for the
                    <span class="font-semibold text-red-600">AISS Dashboard</span>.
                    Add, edit, or remove accounts and control user permissions.
                </p>
            </div>
        </div>

        {{-- ===== ADD NEW USER FORM ===== --}}
        <div class="mb-6">
            <div class="ml-2 mb-3">
                <p class="text-xs font-bold tracking-widest text-red-600 uppercase">Operations Input</p>
                <h2 class="text-xl font-bold text-gray-900">Add New User</h2>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        {{-- Name --}}
                        <div>
                            <label for="add_name" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Full Name</label>
                            <input type="text" name="name" id="add_name" value="{{ old('name') }}" placeholder="e.g., John Doe" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- NPK --}}
                        <div>
                            <label for="add_npk" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">NPK</label>
                            <input type="text" name="npk" id="add_npk" value="{{ old('npk') }}" placeholder="e.g., 12345678" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Email --}}
                        <div>
                            <label for="add_email" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Email <span class="normal-case text-gray-300">(optional)</span></label>
                            <input type="email" name="email" id="add_email" value="{{ old('email') }}" placeholder="email@example.com"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Role --}}
                        <div>
                            <label for="add_role" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Role</label>
                            <select name="role" id="add_role" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        {{-- Password --}}
                        <div>
                            <label for="add_password" class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Password</label>
                            <input type="password" name="password" id="add_password" placeholder="Min. 6 characters" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 placeholder:text-gray-400 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition">
                        </div>
                        {{-- Photo --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Photo <span class="normal-case text-gray-300">(optional)</span></label>
                            <div class="flex items-center gap-3 border border-gray-200 rounded-lg px-1.5 py-1.5 bg-gray-50">
                                <button type="button" id="btn-add-photo"
                                    class="shrink-0 px-4 py-1.5 bg-white border border-gray-200 text-gray-700 font-semibold text-xs rounded-lg transition whitespace-nowrap shadow-sm">
                                    Browse
                                </button>
                                <span id="span-add-photo" class="text-sm text-gray-500 flex-1 truncate">No file selected</span>
                                <input type="file" name="image" id="input-add-photo" accept="image/*" class="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:brightness-110 text-white font-bold text-sm px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200 whitespace-nowrap uppercase">
                            Add User
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="mb-6">
            <div class="flex items-end justify-between mb-3">
                <div class="ml-2">
                    <p class="text-xs font-bold tracking-widest text-red-600 uppercase">User Data</p>
                    <h2 class="text-xl font-bold text-gray-900">Registered Users</h2>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                {{-- Search Bar --}}
                <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form id="user-search-form" method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2 flex-1 max-w-lg">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-3.5-3.5M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search name, NPK, or email..."
                                   class="placeholder:text-gray-400 block w-full pl-9 pr-4 py-2.5 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"/>
                        </div>
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition shrink-0 uppercase">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('users.index') }}" class="px-4 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition shrink-0 uppercase">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-center text-gray-500 font-bold text-[10px] tracking-widest uppercase">
                            <th class="px-5 py-3 text-left">User</th>
                            <th class="px-5 py-3">NPK</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Role</th>
                            <th class="px-5 py-3">Joined</th>
                            <th class="px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($users as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                                {{-- User Info --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                                                class="w-9 h-9 rounded-full object-cover ring-2 ring-gray-100 shrink-0">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-red-400 to-rose-600 flex items-center justify-center shrink-0">
                                                <span class="text-white font-bold text-xs uppercase">{{ mb_substr($item->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-800 text-sm leading-tight">{{ $item->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- NPK --}}
                                <td class="px-5 py-4 text-center">
                                    <div class="text-sm font-mono text-slate-500">{{ $item->npk }}</div>
                                </td>
                                {{-- Email --}}
                                <td class="px-5 py-4 text-center">
                                    <div class="text-sm text-gray-600">{{ $item->email ?? '—' }}</div>
                                </td>
                                {{-- Role --}}
                                <td class="px-5 py-4 text-center">
                                    @if($item->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                            User
                                        </span>
                                    @endif
                                </td>
                                {{-- Joined --}}
                                <td class="px-5 py-4 text-center">
                                    <div class="text-sm font-mono text-gray-500">{{ $item->created_at->format('Y-m-d') }}</div>
                                </td>
                                {{-- Actions --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                                        {{-- Edit Button --}}
                                        <a href="javascript:void(0)"
                                            data-modal-open="edit-user-modal-{{ $item->id }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-500 text-white hover:bg-sky-600 transition shadow-sm"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        {{-- Delete Button --}}
                                        <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Hapus user {{ $item->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-red-600 transition shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <p class="text-gray-400 text-sm">Belum ada user terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                    <p class="text-xs text-slate-400 font-medium">
                        Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} user{{ $users->total() !== 1 ? 's' : '' }}
                    </p>
                    <div class="flex items-center gap-2">
                        @if ($users->onFirstPage())
                            <span class="px-4 py-1.5 text-xs font-semibold text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-4 py-1.5 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">Previous</a>
                        @endif
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-4 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-lg hover:brightness-110 shadow-sm transition">Next</a>
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

{{-- ===== EDIT MODALS ===== --}}
@foreach($users as $item)
    <x-ui.modal id="edit-user-modal-{{ $item->id }}">
        <div class="w-full bg-white rounded-2xl shadow-2xl flex flex-col" style="width: 680px; max-width: 95vw; max-height: 90vh;">

            {{-- Modal Header --}}
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 shrink-0 rounded-t-2xl">
                <div class="w-9 h-9 rounded-xl bg-sky-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 uppercase">Edit User</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Update data for {{ $item->name }}</p>
                </div>
                <button data-modal-close="edit-user-modal-{{ $item->id }}"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form action="{{ route('users.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Name --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ $item->name }}" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
                        </div>
                        {{-- NPK --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">NPK</label>
                            <input type="text" name="npk" value="{{ $item->npk }}" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
                        </div>
                        {{-- Email --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Email <span class="normal-case text-gray-300">(optional)</span></label>
                            <input type="email" name="email" value="{{ $item->email }}"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
                        </div>
                        {{-- Role --}}
                        <div>
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Role</label>
                            <select name="role" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
                                <option value="user" {{ $item->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $item->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        {{-- Password --}}
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">
                                New Password <span class="normal-case text-gray-300">(leave blank to keep current)</span>
                            </label>
                            <input type="password" name="password" placeholder="Min. 6 characters"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-700 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
                        </div>
                        {{-- Photo --}}
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">
                                Photo <span class="normal-case text-gray-300">(optional — leave blank to keep current)</span>
                            </label>
                            <div class="flex items-center gap-3">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                                        class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200 shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-rose-600 flex items-center justify-center shrink-0">
                                        <span class="text-white font-bold text-sm uppercase">{{ mb_substr($item->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center gap-3 flex-1 border border-gray-200 rounded-lg px-1.5 py-1.5 bg-gray-50">
                                    <button type="button" class="edit-photo-btn shrink-0 px-4 py-1.5 bg-white border border-gray-200 text-gray-700 font-semibold text-xs rounded-lg shadow-sm">
                                        Browse
                                    </button>
                                    <span class="edit-photo-name text-sm text-gray-500 flex-1 truncate">No new file</span>
                                    <input type="file" name="image" accept="image/*" class="edit-photo-input hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 shrink-0 rounded-b-2xl bg-gray-50/50">
                    <button type="button" data-modal-close="edit-user-modal-{{ $item->id }}"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl hover:brightness-110 shadow-sm transition">
                        Save Changes
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ADD FORM — Photo picker
    const btnAddPhoto   = document.getElementById('btn-add-photo');
    const inputAddPhoto = document.getElementById('input-add-photo');
    const spanAddPhoto  = document.getElementById('span-add-photo');

    if (btnAddPhoto && inputAddPhoto) {
        btnAddPhoto.addEventListener('click', () => inputAddPhoto.click());
        inputAddPhoto.addEventListener('change', () => {
            spanAddPhoto.textContent = inputAddPhoto.files.length > 0
                ? inputAddPhoto.files[0].name
                : 'No file selected';
        });
    }

    // EDIT MODALS — Photo pickers
    document.querySelectorAll('.edit-photo-btn').forEach(btn => {
        const wrapper = btn.closest('.flex.items-center.gap-3.flex-1');
        const fileInput = wrapper.querySelector('.edit-photo-input');
        const label = wrapper.querySelector('.edit-photo-name');

        btn.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => {
            label.textContent = fileInput.files.length > 0
                ? fileInput.files[0].name
                : 'No new file';
        });
    });
});
</script>
@endsection
