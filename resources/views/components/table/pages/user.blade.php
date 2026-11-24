@props(['users'])

@php
    $roleBadges = [
        'admin'  => 'bg-red-100 text-red-700',
        'leader' => 'bg-sky-100 text-sky-700',
        'user'   => 'bg-slate-100 text-slate-600',
    ];
@endphp

<div class="mb-6">
    {{-- Title & Description --}}
    <div class="flex items-end justify-between">
        <x-typography.heading eyebrow="User Data" title="Registered Users" />
    </div>
    {{-- ===== TABLE USERS DATA ===== --}}
    <x-table :headers="['User', 'NPK', 'Email', 'Role', 'Joined', 'Actions']">
        {{-- Table Header --}}
        <x-slot:toolbar>
            <x-table.search :action="route('users.index')" placeholder="Search name, NPK, or email..." />
        </x-slot:toolbar>
        {{-- Table Content --}}
        @forelse ($users as $item)
            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                {{-- User Info --}}
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <x-user.avatar :user="$item" />
                        <div class="font-semibold text-gray-800 text-sm leading-tight">{{ $item->name }}</div>
                    </div>
                </td>
                {{-- NPK --}}
                <td class="px-5 py-4 text-center text-sm font-mono text-slate-500">
                    {{ $item->npk }}
                </td>
                {{-- Email --}}
                <td class="px-5 py-4 text-center text-sm text-gray-600">
                    {{ $item->email ?? '—' }}
                </td>
                {{-- Role --}}
                <td class="px-5 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold capitalize {{ $roleBadges[$item->role] ?? $roleBadges['user'] }}">
                        {{ $item->role }}
                    </span>
                </td>
                {{-- Joined --}}
                <td class="px-5 py-4 text-center text-sm font-mono text-gray-500">
                    {{ $item->created_at->format('Y-m-d') }}
                </td>
                {{-- Actions --}}
                <td class="px-5 py-4">
                    <x-table.action-hover>
                        {{-- Button Edit --}}
                        <x-button-group variant="info" class="!rounded-full">
                            <button data-modal-open="edit-user-modal-{{ $item->id }}" type="button" title="Edit" class="!w-8">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </x-button-group>
                        {{-- Button Delete --}}
                        <form action="{{ route('users.destroy', $item->id) }}" method="POST" aria-label="Delete user" onsubmit="return confirm('Hapus user {{ $item->name }}?')">
                            @csrf
                            @method('DELETE')
                            <x-button-group variant="danger" class="!rounded-full">
                                <button type="submit" title="Delete" class="!w-8">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </x-button-group>
                        </form>
                    </x-table.action-hover>
                </td>
            </tr>
            {{-- Modal Edit --}}
            <x-modal.pages.edit-user :item="$item" />
        @empty
            {{-- Table Empty --}}
            <x-table.empty :colspan="6" message="Belum ada user terdaftar." />
        @endforelse
        {{-- Table Footer --}}
        <x-slot:footer>
            <x-pagination :paginator="$users" label="user" variant="numbered" />
        </x-slot:footer>
    </x-table>
</div>
