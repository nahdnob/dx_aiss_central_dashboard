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
    <x-ui.navbar />
    
    <x-ui.header>@yield('header')</x-ui.header>

    <main>
        <x-ui.main>@yield('content')</x-ui.main>
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