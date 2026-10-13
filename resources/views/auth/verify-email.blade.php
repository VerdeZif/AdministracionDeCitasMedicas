<x-guest-layout>
    <div class="text-center mb-8 max-w-sm mx-auto">
        <h1 class="text-2xl font-bold text-[#273B69]">Verificar Correo</h1>
        <p class="text-gray-500 mt-2 text-sm">
            ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar?
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-bold text-sm text-[#0A1F8F] bg-[#D6EEE8] p-4 rounded-xl text-center shadow-sm max-w-sm mx-auto">
            Se ha enviado un nuevo enlace de verificación a tu correo.
        </div>
    @endif

    <div class="mt-4 flex flex-col space-y-4 max-w-sm mx-auto">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#273B69] hover:bg-[#1e2d52] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#273B69] transition-colors uppercase tracking-wider">
                Reenviar Correo
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm font-bold text-[#273B69] hover:text-[#4DB6AC] transition-colors py-2">
                Cerrar Sesión
            </button>
        </form>
    </div>
</x-guest-layout>