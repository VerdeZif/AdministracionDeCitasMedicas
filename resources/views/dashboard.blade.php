@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Encabezado del Panel -->
    <div class="bg-white rounded-xl shadow-sm border-t-4 border-brand-dark p-6 mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-brand-dark">Panel de Control</h2>
            <p class="text-sm opacity-75 mt-1">Bienvenido de nuevo, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        
        <!-- Botón real para Cerrar Sesión -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm underline hover:no-underline transition">
                Cerrar Sesión
            </button>
        </form>
    </div>

    <!-- Contenedor central (Aquí irán las métricas luego) -->
    <div class="bg-white rounded-xl shadow-sm p-10 text-center border border-gray-100">
        <div class="w-20 h-20 bg-brand-light rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-brand-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-brand-dark mb-3">Tu entorno de trabajo está listo</h3>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            Este es el espacio privado. En el siguiente paso dividiremos esta vista para mostrar las métricas del administrador, la agenda del médico o el historial del paciente.
        </p>
        
        <a href="{{ route('home') }}" class="inline-block bg-brand-dark hover:bg-blue-900 text-white font-semibold py-3 px-8 rounded-lg transition-colors shadow">
            Volver al Inicio
        </a>
    </div>

</div>
@endsection