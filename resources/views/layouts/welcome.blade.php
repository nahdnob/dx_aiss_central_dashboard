<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In - AISS Central Dashboard</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    </head>
    <body>
        {{-- Main Content --}}
        <main class="min-h-screen flex items-center justify-center px-6 py-12">
            @yield('content')
        </main>
        {{-- Scripts --}}
        @stack('scripts')
    </body>
</html>