@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- TÍTULO CORREGIDO -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold text-brand-dark">Nuestros Servicios Médicos</h2>
        <p class="mt-4 text-lg opacity-80">Conoce las áreas en las que podemos ayudarte en Healthy Live.</p>
    </div>

    <!-- Cuadrícula de servicios (Hasta 3 columnas) -->
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @php
            $specialties = \App\Models\Specialty::all();
        @endphp

        @foreach($specialties as $specialty)
        <div class="bg-white overflow-hidden shadow-md rounded-lg flex flex-col hover:shadow-xl transition-shadow duration-300">
            
            <!-- Parte superior de la tarjeta (Ícono, Título, Descripción) -->
            <div class="p-6 flex-grow">
                <!-- Ícono SVG genérico médico -->
                <div class="w-12 h-12 bg-brand-light rounded-lg flex items-center justify-center mb-4 text-brand-dark">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl leading-6 font-bold text-brand-dark mb-2">{{ $specialty->name }}</h3>
                <p class="text-sm opacity-75">{{ $specialty->description }}</p>
            </div>

            <!-- Base dividida por una línea (Precio y Botón de Reserva) -->
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-4 flex items-center justify-between">
                <div>
                    <span class="block text-xs font-semibold opacity-70 uppercase tracking-wide">Consulta</span>
                    <span class="text-lg font-bold text-brand-dark">S/ {{ number_format($specialty->price, 2) }}</span>
                </div>
                
                <a href="{{ route('patient.appointments.create') }}" class="bg-brand-action hover:bg-brand-action-hover text-white text-sm font-semibold py-2 px-4 rounded transition-colors shadow">
                    Reservar
                </a>
            </div>
            
        </div>
        @endforeach
    </div>
</div>
@endsection