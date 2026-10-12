<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Healthy Life') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- Fondo base que se ve en móvil, y en PC se vuelve blanco -->
<body class="font-sans text-[#273B69] antialiased bg-[#F4F9F8] lg:bg-white relative">
    
    <!-- FONDO DECORATIVO SOLO PARA MÓVIL/TABLET -->
    <div class="absolute inset-0 z-0 lg:hidden overflow-hidden pointer-events-none">
        <svg class="absolute -top-[5%] -right-[20%] w-[120vw] text-[#D6EEE8] opacity-80 transform rotate-12" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M45.7,-76.4C58.9,-69.3,69.1,-55.3,77.5,-40.8C85.9,-26.3,92.5,-11.3,91.3,3C90.1,17.3,81.1,30.9,71,43.2C60.9,55.5,49.6,66.4,36.2,74.1C22.8,81.8,7.3,86.3,-7.4,87.6C-22.1,88.9,-36,87,-48.6,80.1C-61.2,73.2,-72.5,61.3,-80.6,47.2C-88.7,33.1,-93.6,16.5,-92.4,1C-91.2,-14.5,-83.9,-29,-74,-40.8C-64.1,-52.6,-51.6,-61.7,-38.3,-68.8C-25,-75.9,-12.5,-81.1,2.3,-84.3C17.1,-87.5,32.5,-83.5,45.7,-76.4Z" transform="translate(100 100)" />
        </svg>
    </div>

    <div class="min-h-screen flex flex-col lg:flex-row relative z-10">
        
        <!-- MITAD IZQUIERDA: IMAGEN (Solo en PC) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#D6EEE8] items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-[#273B69]/10 z-10 mix-blend-multiply"></div>
            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=1000&auto=format&fit=crop" alt="Staff Healthy Life" class="absolute inset-0 w-full h-full object-cover">
            
            <div class="relative z-20 text-center text-white px-12 pb-20 mt-auto drop-shadow-lg bg-gradient-to-t from-[#273B69]/90 to-transparent w-full pt-32">
                <h2 class="text-4xl font-bold mb-4 uppercase tracking-wider">Bienvenido a<br>Healthy Life</h2>
                <p class="text-lg">Tu salud en las mejores manos, gestiona tus citas médicas de forma rápida y segura.</p>
            </div>
        </div>

        <!-- MITAD DERECHA: FORMULARIO -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-4 sm:p-8 lg:p-24 relative lg:bg-white min-h-screen">
            
            <!-- Botón Volver -->
            <a href="{{ route('home') }}" class="absolute top-6 left-6 text-[#273B69] hover:text-[#4DB6AC] flex items-center gap-2 font-bold transition-colors z-20 bg-white/50 lg:bg-transparent px-3 py-1.5 rounded-full lg:px-0 lg:py-0 backdrop-blur-sm lg:backdrop-blur-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>

            <!-- Contenedor Tarjeta: En móvil es una tarjeta blanca, en PC se fusiona con el fondo -->
            <div class="w-full max-w-xl bg-white lg:bg-transparent rounded-3xl shadow-2xl lg:shadow-none p-6 sm:p-10 lg:p-0 mt-16 lg:mt-0 border border-gray-100 lg:border-none relative z-10">
                
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" class="h-16 lg:h-20 object-contain" alt="Logo">
                    </a>
                </div>
                
                <!-- Contenido dinámico (Login/Registro) -->
                {{ $slot }}
                
            </div>
        </div>

    </div>
</body>
</html>