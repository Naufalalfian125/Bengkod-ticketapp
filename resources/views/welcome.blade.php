<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BengTix - Beli Tiket, Auto Asik</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/logo_bengkod.svg') }}" alt="Bengkel Koding" class="h-10 w-10">
                    <span class="text-gray-800 font-semibold text-lg">Bengkel Koding</span>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="bg-[#1e3a8a] min-h-screen flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                Hi, Amankan Tiketmu yuk.
            </h1>
            <p class="text-white text-xl md:text-2xl lg:text-3xl font-medium">
                BengTix: Beli tiket, auto asik.
            </p>
            
            @guest
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 font-semibold text-lg transition">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-semibold text-lg transition">
                        Daftar Akun
                    </a>
                </div>
            @else
                <div class="mt-8">
                    <a href="{{ route('event.index') }}" class="inline-block px-8 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 font-semibold text-lg transition">
                        Lihat Event
                    </a>
                </div>
            @endguest
        </div>
    </main>
</body>
</html>
