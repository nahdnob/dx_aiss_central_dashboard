@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
    <div class="p-4 min-h-[calc(100vh-5rem)]">

        {{-- ===== HERO HEADER ===== --}}
        <x-jumbotron
            :title="$machine->asset_name"
            :image="$machine->image_path ? 'storage/machines/images/' . $machine->image_path : null"
            :breadcrumbs="[
                ['label' => 'Machine List', 'url' => route('machines.index')],
                ['label' => $machine->asset_no],
            ]">
            Edit machine information and manage linked SOP documents.
        </x-jumbotron>

        <x-card.pages.machine-summary :machine="$machine" />
        
        <x-form.pages.machine-edit :machine="$machine" :errors="$errors" />

        <x-table.pages.machine-sop :machine="$machine" :availableSops="$availableSops" />
    </div>
    <x-footer />
</div>

<x-modal.pages.link-sop :machine="$machine" :availableSops="$availableSops" />