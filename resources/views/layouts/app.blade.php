<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AISS Central Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
</head>
<body>
    <x-navbar />
    
    <x-layout.header>@yield('header')</x-layout.header>

    <main>
        <x-layout.main>@yield('content')</x-layout.main>
    </main>
</body>
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
</html>