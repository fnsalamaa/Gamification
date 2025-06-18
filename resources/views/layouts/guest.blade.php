<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('storage/welcome/background.png') }}');">
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black/40 backdrop-blur-sm">
        <div>
            <a href="/">
                <img src="{{ asset('storage/welcome/logo.jpeg') }}" alt="Logo"
                    class="w-20 h-20 rounded-full ring-2 ring-pink-300 shadow-lg transition duration-300 hover:scale-105 object-cover" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/90 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
