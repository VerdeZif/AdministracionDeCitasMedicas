@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-3xl w-full mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-brand-action overflow-hidden">
            
            <div class="bg-brand-light p-6 text-center border-b border-gray-100 flex items-center justify-center gap-2">
                <a href="{{ route('home') }}" class="text-brand-action hover:text-brand-dark transition font-bold text-xl">&lt;</a>
                <h2 class="text-2xl font-extrabold text-brand-dark">Registro en Citas en Línea</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Tipo de Documento -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Tipo Documento de Identidad</label>
                        <select name="document_type" class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border">
                            <option value="DNI">DNI</option>
                            <option value="CE">Carné de Extranjería</option>
                            <option value="PAS">Pasaporte</option>
                        </select>
                    </div>

                    <!-- Número de Documento (Con el botón de búsqueda falso por ahora) -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Número Documento de Identidad <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="dni" required placeholder="Ingresa tu DNI ó Documento" class="flex-1 rounded-l-md border-gray-300 focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                            <button type="button" class="inline-flex items-center px-4 rounded-r-md border border-l-0 border-brand-dark bg-brand-dark text-white hover:bg-blue-900">
                                🔍
                            </button>
                        </div>
                    </div>

                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombres <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Ingresa tus nombres" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    </div>

                    <!-- Apellido Paterno -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellido Paterno <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name_paternal" required placeholder="Ingresa tu apellido paterno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    </div>

                    <!-- Apellido Materno -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellido Materno <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name_maternal" required placeholder="Ingresa tu apellido materno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-mail <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="Ingresa tu e-mail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha Nacimiento <span class="text-red-500">*</span></label>
                        <input type="date" name="birth_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border text-gray-500">
                    </div>

                    <!-- Teléfono Móvil -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono Móvil <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" required placeholder="Ingresa tu celular" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    </div>

                    <!-- Sexo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sexo <span class="text-red-500">*</span></label>
                        <select name="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border text-gray-500">
                            <option value="">SELECCIONE SEXO</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required placeholder="Contraseña" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    </div>

                    <!-- Repita Contraseña -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Repita Contraseña <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Repita Contraseña" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    </div>
                </div>

                <!-- Simulación reCAPTCHA -->
                <div class="mt-4 border border-gray-300 p-4 rounded-md w-max flex items-center gap-4 bg-gray-50">
                    <input type="checkbox" required class="w-6 h-6 border-gray-400 rounded">
                    <span class="text-sm font-medium">No soy un robot</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/RecaptchaLogo.svg/200px-RecaptchaLogo.svg.png" alt="reCAPTCHA" class="h-8 ml-4">
                </div>

                <!-- Términos -->
                <div class="mt-4">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" required class="rounded border-gray-400 text-brand-action shadow-sm focus:ring-brand-action mr-2">
                        Acepto los <a href="#" class="text-brand-action underline mx-1">Términos y Condiciones</a> y la <a href="#" class="text-brand-action underline mx-1">Política de Privacidad</a> establecidos.
                    </label>
                </div>

                <!-- Botón de Registro -->
                <div class="mt-8">
                    <button type="submit" class="w-full bg-brand-action hover:bg-brand-action-hover text-white font-bold py-4 px-8 shadow-md transition-colors text-lg uppercase tracking-wide">
                        Registrarme
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection