@php
    $roles = ['user' => 'User', 'leader' => 'Leader', 'admin' => 'Admin'];
@endphp

<div class="mb-6">
    <x-typography.heading eyebrow="Operations Input" title="Add New User" />
    <x-card class="p-5">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <x-form.input id="add_name" name="name" label="Full Name" placeholder="e.g., John Doe" required />
                <x-form.input id="add_npk" name="npk" label="NPK" placeholder="e.g., 12345678" required />
                <x-form.input id="add_email" name="email" type="email" label="Email (optional)" placeholder="email@example.com" />
                <x-form.select id="add_role" name="role" label="Role" :options="$roles" value="user" required />
                <x-form.input id="add_password" name="password" type="password" label="Password" placeholder="Min. 6 characters" required />
                <x-form.file-input id="add_image" name="image" label="Photo (optional)" accept="image/*" placeholder="No file selected" />
            </div>
            <div class="flex justify-end">
                <x-button variant="success" type="submit" class="w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add User
                </x-button>
            </div>
        </form>
    </x-card>
</div>
