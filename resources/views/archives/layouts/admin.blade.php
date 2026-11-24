<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100">

{{-- Top Navbar --}}
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-4 py-3 flex items-center justify-between">

        {{-- Left --}}
        <div class="flex items-center gap-3">
            <button data-drawer-target="admin-sidebar"
                data-drawer-toggle="admin-sidebar"
                class="sm:hidden p-2 rounded hover:bg-gray-100">
                ☰
            </button>

            <span class="text-lg font-semibold">
                Admin Panel
            </span>
        </div>

        {{-- Right User --}}
        <div>
            <span class="text-sm text-gray-600">
                {{ auth()->user()->name ?? 'Guest' }}
            </span>
        </div>

    </div>
</nav>

{{-- Sidebar --}}
<aside id="admin-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-16
           transition-transform -translate-x-full sm:translate-x-0
           bg-gray-900 text-white">

    <div class="p-4 space-y-2">

        <a href=""
           class="block px-3 py-2 rounded
           {{ request()->routeIs('admin.dashboard') ? 'bg-sky-600' : 'hover:bg-gray-800' }}">
            Dashboard
        </a>

        <a href=""
           class="block px-3 py-2 rounded
           {{ request()->routeIs('admin.settings') ? 'bg-sky-600' : 'hover:bg-gray-800' }}">
            Settings
        </a>

        <a href=""
           class="block px-3 py-2 rounded
           {{ request()->routeIs('admin.users') ? 'bg-sky-600' : 'hover:bg-gray-800' }}">
            Users
        </a>

    </div>
</aside>

{{-- Content --}}
<div class="sm:ml-64 pt-16 p-6">

    <h1 class="text-xl font-semibold mb-6">
        @yield('header')
    </h1>

    @yield('content')

</div>

{{-- Toast Session --}}
@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Toast.show(@json(session('success')), 'success');
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Toast.show(@json(session('error')), 'error');
});
</script>
@endif

</body>
</html>