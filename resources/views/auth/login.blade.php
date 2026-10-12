@extends('layouts.app')

@section('content')
<div class="py-12 bg-brand-light min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-4">
        <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-brand-dark">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-brand-dark">Iniciar Sesión</h2>
                <p class="text-gray-500 mt-2">Ingresa a tu panel de Healthy Live.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label class="block text-sm font-medium text-brand-dark">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-brand-dark">Contraseña</label>
                    <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action p-2 border">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-action shadow-sm focus:ring-brand-action">
                        <span class="ms-2 text-sm text-gray-600">Recordar mi sesión</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-brand-dark" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-brand-action hover:bg-brand-action-hover text-white font-bold py-3 px-4 rounded-lg shadow transition-colors">
                        Ingresar al Sistema
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <span class="text-sm text-gray-600">¿No eres paciente aún? <a href="{{ route('register') }}" class="text-brand-action font-bold hover:underline">Regístrate aquí</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection