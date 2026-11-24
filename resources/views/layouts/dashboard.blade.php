<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('head')
    <title>AISS Central Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <x-navbar.dashboard />

    <x-toast />

    <x-sidebar />
    
    <main>
        @yield('content')
    </main>

    @auth
        <x-modal id="profile-modal" maxWidth="max-w-md">
            <x-card.profile
                :name="Auth::user()->name"
                :email="Auth::user()->email ?? ''"
                :verified="Auth::user()->email_verified_at !== null"
                :npk="Auth::user()->npk"
                :image="Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/profile-blank.jpg')"
            />
        </x-modal>
    @endauth

    <x-modal id="login-modal" maxWidth="max-w-3xl">
        <x-form.pages.login />
    </x-modal>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

    @stack('scripts')
</body>
</html>