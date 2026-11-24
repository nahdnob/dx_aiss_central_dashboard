@extends('layouts.dashboard')

@section('content')
    <div class="p-4 sm:ml-16 mt-14 transition-all duration-300">
        <div class="p-4 min-h-[calc(100vh-5rem)]">

            {{-- HERO HEADER --}}
            <x-jumbotron title="USER MANAGEMENT" image="assets/images/performance.jpg" alt="User Management">
                Manage system users and their access roles for the
                <span class="font-semibold text-red-600">AISS Dashboard</span>.
                Add, edit, or remove accounts and control user permissions.
            </x-jumbotron>

            {{-- FORM ADD NEW USER --}}
            <x-form.pages.user-create />

            {{-- TABLE USERS DATA --}}
            <x-table.pages.user :users="$users" />
        </div>

        {{-- FOOTER --}}
        <x-footer />
    </div>
@endsection
