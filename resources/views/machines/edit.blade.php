@extends('layouts.system-manager')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <x-layout.page-hero
            :title="$machine->asset_name"
            :image="$machine->image_path ? 'storage/machines/images/' . $machine->image_path : null"
            :breadcrumbs="[
                ['label' => 'Machine List', 'url' => route('machines.index')],
                ['label' => $machine->asset_no],
            ]">
            Edit machine information and manage linked SOP documents.
        </x-layout.page-hero>

        <x-machine.summary :machine="$machine" />
        
        <x-machine.form-edit :machine="$machine" :errors="$errors" />

        <x-machine.table-sops :machine="$machine" :availableSops="$availableSops" />
    </div>
    <x-layout.footer />
</div>

<x-machine.modal-link-sop :machine="$machine" :availableSops="$availableSops" />