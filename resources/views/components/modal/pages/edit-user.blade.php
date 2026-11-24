@props(['item'])

@php
    $itemId  = data_get($item, 'id', '');
    $modalId = 'edit-user-modal-' . $itemId;
    $roles   = ['user' => 'User', 'leader' => 'Leader', 'admin' => 'Admin'];
@endphp

<x-modal :id="$modalId" maxWidth="max-w-2xl">

    <x-modal.partials.header title="Edit User" description="Update data for {{ data_get($item, 'name') }}." />

    <form method="POST" action="{{ route('users.update', $itemId) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form.input
                id="user-name-{{ $itemId }}"
                name="name" label="Full Name"
                :value="data_get($item, 'name', '')"
                :required="true" />

            <x-form.input
                id="user-npk-{{ $itemId }}"
                name="npk" label="NPK"
                :value="data_get($item, 'npk', '')"
                :required="true" />

            <x-form.input
                id="user-email-{{ $itemId }}"
                name="email" type="email" label="Email (optional)"
                :value="data_get($item, 'email', '')" />

            <x-form.select
                id="user-role-{{ $itemId }}"
                name="role" label="Role"
                :options="$roles"
                :value="data_get($item, 'role', 'user')"
                :required="true" />

            <x-form.input
                id="user-password-{{ $itemId }}"
                name="password" type="password" label="New Password"
                placeholder="Leave blank to keep current"
                class="sm:col-span-2" />

            <div class="sm:col-span-2 flex items-end gap-3">
                <x-user.avatar :user="$item" size="w-10 h-10" class="mb-1" />
                <x-form.file-input
                    id="user-image-{{ $itemId }}"
                    name="image" label="Photo (optional — leave blank to keep current)"
                    accept="image/*"
                    placeholder="No new file" />
            </div>
        </div>

        <x-modal.partials.footer
            variant="inline"
            :modal-id="$modalId"
            :prefix="'user-' . $itemId"
            submit-label="Save Changes" />
    </form>
</x-modal>
