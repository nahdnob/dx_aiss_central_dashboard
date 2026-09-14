<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — AISS Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-red-50">
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <x-auth.login-form />
    </div>

    <x-line-select-modal :lines="$lines" />
</body>
</html>
