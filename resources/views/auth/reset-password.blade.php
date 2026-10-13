<x-guest-layout>
    <div class="text-center mb-8 max-w-sm mx-auto">
        <h1 class="text-2xl font-bold text-[#273B69]">Restablecer Contraseña</h1>
        <p class="text-gray-500 mt-2 text-sm">Ingresa tu nueva contraseña a continuación.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5 max-w-sm mx-auto">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block font-bold text-sm text-[#273B69]">Correo Electrónico</label>
            <input id="email" class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring-[#273B69] p-3 text-sm" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div>
            <label for="password" class="block font-bold text-sm text-[#273B69]">Nueva Contraseña</label>
            <input id="password" class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring-[#273B69] p-3 text-sm" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div>
            <label for="password_confirmation" class="block font-bold text-sm text-[#273B69]">Confirmar Contraseña</label>
            <input id="password_confirmation" class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring-[#273B69] p-3 text-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#273B69] hover:bg-[#1e2d52] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#273B69] transition-colors uppercase tracking-wider">
                Restablecer Contraseña
            </button>
        </div>
    </form>
</x-guest-layout>