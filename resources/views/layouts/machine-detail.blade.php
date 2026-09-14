<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine Detail - DENSO</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
    <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur-xl shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/denso_logo.png') }}" class="h-12 w-auto object-contain" alt="DENSO">
                <div class="pl-3">
                    <p class="text-base font-semibold uppercase tracking-[0.35em] text-slate-500">AISS</p>
                    <p class="text-xl font-semibold text-slate-900 uppercase">Machine Specification</p>
                </div>
            </div>
            <div class="text-sm text-slate-500 hidden sm:block">
                <!-- Halaman khusus spesifikasi mesin -->
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

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
