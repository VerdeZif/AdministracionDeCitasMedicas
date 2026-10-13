<x-guest-layout>
    <div class="text-center mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#273B69]">Iniciar Sesión</h1>
        <p class="text-gray-500 mt-2 text-xs sm:text-sm">Ingresa a tu panel de Healthy Life.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5 sm:space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Correo Electrónico</label>
            <input id="email" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="correo@ejemplo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs sm:text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Contraseña</label>
            <input id="password" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs sm:text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-gray-400 text-[#273B69] shadow-sm focus:ring-[#273B69]">
                <span class="ms-2 text-xs sm:text-sm text-gray-600 font-medium">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs sm:text-sm font-bold text-[#4DB6AC] hover:text-[#273B69] transition-colors" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Botón Ingresar -->
        <div class="pt-2 sm:pt-4">
            <button type="submit" class="w-full flex justify-center py-3 sm:py-4 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#273B69] hover:bg-[#1e2d52] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#273B69] transition-colors uppercase tracking-wider">
                Ingresar al Sistema
            </button>
        </div>
        
        <!-- Enlace a Registro -->
        <div class="text-center mt-4 sm:mt-6">
            <p class="text-xs sm:text-sm text-gray-600">
                ¿No eres paciente aún? 
                <a href="{{ route('register') }}" class="font-bold text-[#273B69] hover:text-[#4DB6AC] transition-colors border-b-2 border-[#4DB6AC]">Regístrate aquí</a>
            </p>
        </div>
    </form>
</x-guest-layout>