@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-brand-dark sm:text-4xl">Contáctenos</h2>
        <p class="mt-4 text-lg opacity-80">Estamos aquí para resolver tus dudas y ayudarte con tus citas.</p>
    </div>

    <!-- Distribución a dos columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Columna Izquierda: Tarjetas de Información apiladas -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-brand-action flex items-start">
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-brand-dark">Sede Central</h3>
                    <p class="mt-1 text-sm opacity-75">Av. Principal 123, San Juan de Lurigancho, Lima</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-brand-action flex items-start">
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-brand-dark">Central Telefónica</h3>
                    <p class="mt-1 text-sm opacity-75">(01) 555-1234 / 999-000-001</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-brand-action flex items-start">
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-brand-dark">Horario de Atención</h3>
                    <p class="mt-1 text-sm opacity-75">Lunes a Sábado: 8:00 AM - 8:00 PM<br>Domingos: 8:00 AM - 1:00 PM</p>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Formulario sobre fondo blanco -->
        <div class="bg-white p-8 rounded-lg shadow-lg border-t-4 border-brand-dark">
            <form action="#" method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-brand-dark">Nombre Completo</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border" placeholder="Juan Pérez">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-brand-dark">Correo Electrónico</label>
                    <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border" placeholder="juan@correo.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand-dark">Mensaje</label>
                    <textarea rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border" placeholder="¿En qué podemos ayudarte?"></textarea>
                </div>

                <button type="submit" class="w-full bg-brand-action hover:bg-brand-action-hover text-white font-bold py-3 px-4 rounded-md transition-colors">
                    Enviar Mensaje
                </button>
            </form>
        </div>

    </div>
</div>
@endsection