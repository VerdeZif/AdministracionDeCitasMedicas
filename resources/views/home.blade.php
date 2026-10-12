@extends('layouts.app')

@section('content')
<div class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Banner Dividido -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Izquierda: Textos y Botones -->
            <div>
                <h1 class="text-4xl tracking-tight font-extrabold text-brand-dark sm:text-5xl md:text-6xl">
                    <span class="block">Tu salud en las</span>
                    <span class="block text-brand-action mt-2">mejores manos</span>
                </h1>
                <p class="mt-4 text-base opacity-80 sm:text-lg md:mt-5 md:text-xl">
                    Bienvenido a Healthy Live. Contamos con los mejores especialistas y sedes cerca de ti. Ingresa a nuestro sistema ágil y gestiona tus consultas médicas sin hacer filas.
                </p>
                <div class="mt-8 sm:flex gap-4">
                    <a href="{{ route('register') }}" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-action hover:bg-brand-action-hover md:py-4 md:text-lg transition-colors shadow-lg">
                        Agendar Cita Ahora
                    </a>
                    <a href="{{ route('services') }}" class="mt-3 sm:mt-0 flex items-center justify-center px-8 py-3 border-2 border-brand-dark text-base font-medium rounded-md text-brand-dark bg-transparent hover:bg-brand-dark hover:text-white md:py-4 md:text-lg transition-all shadow">
                        Ver Especialidades
                    </a>
                </div>
            </div>

            <!-- Derecha: Composición visual de tarjetas superpuestas -->
            <div class="relative h-64 sm:h-80 md:h-96 hidden md:block">
                <!-- Tarjeta de fondo -->
                <div class="absolute top-0 right-10 bg-white p-4 rounded-xl shadow-md border-t-4 border-brand-dark w-64 transform rotate-6 opacity-70">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-brand-light"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    </div>
                    <div class="h-3 bg-gray-200 rounded w-full mb-2"></div>
                    <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                </div>
                <!-- Tarjeta principal superpuesta -->
                <div class="absolute bottom-10 left-10 bg-white p-5 rounded-xl shadow-2xl border-l-4 border-brand-action w-72 z-10">
                    <h3 class="font-bold text-brand-dark mb-1">Cita Confirmada</h3>
                    <p class="text-sm opacity-70 mb-3">Cardiología - Dr. Carlos Ramírez</p>
                    <div class="bg-brand-light text-brand-dark text-xs font-semibold px-3 py-2 rounded">
                        🗓️ 15 Oct 2026 | 10:00 AM
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Beneficios: Cuadrícula de 3 columnas -->
        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto bg-brand-light text-brand-dark rounded-full flex items-center justify-center text-2xl mb-4">
                    💻
                </div>
                <h3 class="text-xl font-bold text-brand-dark mb-2">Citas Online</h3>
                <p class="text-sm opacity-75">Reserva, reprograma o cancela tus turnos desde cualquier dispositivo, las 24 horas del día.</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto bg-brand-light text-brand-dark rounded-full flex items-center justify-center text-2xl mb-4">
                    📄
                </div>
                <h3 class="text-xl font-bold text-brand-dark mb-2">Boletas Digitales</h3>
                <p class="text-sm opacity-75">Generación automática de comprobantes en PDF tras realizar el pago seguro de tu consulta.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto bg-brand-light text-brand-dark rounded-full flex items-center justify-center text-2xl mb-4">
                    👨‍⚕️
                </div>
                <h3 class="text-xl font-bold text-brand-dark mb-2">Staff Especializado</h3>
                <p class="text-sm opacity-75">Contamos con un directorio de médicos altamente capacitados y con amplia experiencia clínica.</p>
            </div>
        </div>

    </div>
</div>
@endsection