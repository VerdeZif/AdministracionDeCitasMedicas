@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-brand-dark sm:text-4xl">Directorio Médico</h2>
        <p class="mt-4 text-lg opacity-80">Conoce al staff especializado de Healthy Live.</p>
    </div>

    <!-- Directorio en cuadrícula de 4 columnas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($doctors as $doctor)
        <div class="bg-white rounded-lg shadow-md border-t-4 border-brand-dark overflow-hidden flex flex-col text-center transition hover:shadow-xl">
            <div class="p-6 flex-grow">
                <!-- Foto circular (Placeholder dinámico) -->
                <img class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-brand-light object-cover" 
                     src="https://ui-avatars.com/api/?name={{ urlencode($doctor->name) }}&background=D6EEE8&color=0A1F8F&size=150" 
                     alt="{{ $doctor->name }}">
                
                <h3 class="text-lg font-bold text-brand-dark">{{ $doctor->name }}</h3>
                
                <!-- Etiqueta de especialidad -->
                <span class="inline-block bg-brand-light text-brand-dark text-xs px-2 py-1 rounded-full font-semibold mt-2">
                    {{ $doctor->specialty->name ?? 'Médico Especialista' }}
                </span>
                
                <p class="text-sm opacity-75 mt-3">Más de 10 años de experiencia clínica.</p>
            </div>
            
            <!-- Botón inferior de ancho completo -->
            <a href="{{ route('register') }}" class="w-full block bg-brand-action hover:bg-brand-action-hover text-white font-semibold py-3 transition-colors">
                Agendar Cita
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection