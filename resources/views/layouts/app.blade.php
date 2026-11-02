<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PaletteForge — Generator Palet Warna Harmonis')</title>
    <meta name="description" content="Aplikasi pembuat palet warna harmonis bagi desainer dan web developer berbasis algoritma harmoni HSL.">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%23111827'/><circle cx='35' cy='35' r='16' fill='%23F43F5E'/><circle cx='65' cy='35' r='16' fill='%2306B6D4'/><circle cx='50' cy='65' r='16' fill='%2310B981'/></svg>">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="pf-body">
    <x-navbar />

    <main class="pf-main">
        @yield('content')
    </main>

    <x-footer />
    <x-toast />
</body>
</html>
