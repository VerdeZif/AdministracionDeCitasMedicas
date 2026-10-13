<x-guest-layout>
    
    <div class="text-center mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#273B69]">Registro de Pacientes</h1>
        <p class="text-gray-500 mt-2 text-xs sm:text-sm">Crea tu cuenta para acceder a Citas en Línea.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5 sm:space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            
            <div class="md:col-span-2">
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Tipo Documento de Identidad</label>
                <select name="document_type" id="document_type" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors text-gray-700">
                    <option value="DNI">DNI</option>
                    <option value="CE">Carné de Extranjería</option>
                    <option value="PAS">Pasaporte</option>
                </select>
            </div>

            <!-- Número Documento (Con validación dinámica por JS) -->
            <div class="md:col-span-2">
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Número Documento de Identidad <span class="text-red-500">*</span></label>
                <div class="flex shadow-sm rounded-xl">
                    <input type="text" name="dni" id="document_number" required maxlength="8" pattern="[0-9]{8}" title="El DNI debe tener exactamente 8 números" placeholder="N° de Documento" oninput="validateDocument(this)" class="flex-1 rounded-l-xl border-gray-300 focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors w-full min-w-0">
                    <button type="button" class="inline-flex items-center px-4 sm:px-5 rounded-r-xl border border-l-0 border-[#273B69] bg-[#273B69] text-white hover:bg-[#1e2d52] transition-colors font-bold text-xs sm:text-sm">
                        <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="hidden sm:inline">Buscar</span>
                    </button>
                </div>
            </div>

            <!-- Nombres (Bloquea números en tiempo real) -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Nombres <span class="text-red-500">*</span></label>
                <input type="text" name="name" :value="old('name')" required pattern="[a-zA-ZÀ-ÿ\s]+" title="Solo se permiten letras" placeholder="Nombres" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '')" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
            </div>

            <!-- Apellido Paterno (Bloquea números en tiempo real) -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Apellido Paterno <span class="text-red-500">*</span></label>
                <input type="text" name="last_name_paternal" :value="old('last_name_paternal')" required pattern="[a-zA-ZÀ-ÿ\s]+" title="Solo se permiten letras" placeholder="Apellido Paterno" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '')" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors">
            </div>

            <!-- Apellido Materno (Bloquea números en tiempo real) -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Apellido Materno <span class="text-red-500">*</span></label>
                <input type="text" name="last_name_maternal" :value="old('last_name_maternal')" required pattern="[a-zA-ZÀ-ÿ\s]+" title="Solo se permiten letras" placeholder="Apellido Materno" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '')" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors">
            </div>

            <!-- Email (Validación HTML5 nativa) -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">E-mail <span class="text-red-500">*</span></label>
                <input type="email" name="email" :value="old('email')" required placeholder="correo@ejemplo.com" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Nacimiento <span class="text-red-500">*</span></label>
                <input type="date" name="birth_date" :value="old('birth_date')" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors text-gray-500">
            </div>

            <!-- Celular (Exactamente 9 números y bloquea letras) -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Celular <span class="text-red-500">*</span></label>
                <input type="tel" name="phone" :value="old('phone')" required minlength="9" maxlength="9" pattern="[0-9]{9}" title="Debe ingresar exactamente 9 números" placeholder="Celular" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors">
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Sexo <span class="text-red-500">*</span></label>
                <select name="gender" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors text-gray-500">
                    <option value="">SELECCIONE...</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password" required minlength="8" placeholder="Contraseña (Mínimo 8)" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs sm:text-sm font-bold text-[#273B69] mb-1">Repita Contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required minlength="8" placeholder="Repita Contraseña" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#273B69] focus:ring focus:ring-[#273B69]/20 p-3 text-sm transition-colors">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
            </div>
        </div>

        <div class="mt-2 border border-gray-300 p-3 sm:p-4 rounded-xl w-full sm:w-max flex items-center justify-between gap-4 sm:gap-8 bg-gray-50 shadow-sm">
            <div class="flex items-center gap-3">
                <input type="checkbox" required class="w-5 h-5 sm:w-6 sm:h-6 border-gray-400 rounded text-[#273B69] focus:ring-[#273B69]">
                <span class="text-xs sm:text-sm font-medium text-[#273B69]">No soy un robot</span>
            </div>
            <div class="flex flex-col items-center">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#4DB6AC]" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                </svg>
                <span class="text-[8px] sm:text-[9px] text-gray-500 mt-1 font-bold">reCAPTCHA</span>
            </div>
        </div>

        <div class="mt-4">
            <label class="flex items-start text-xs sm:text-sm text-gray-600 cursor-pointer">
                <input type="checkbox" required class="mt-0.5 rounded border-gray-400 text-[#273B69] shadow-sm focus:ring-[#273B69] mr-2">
                <span>Acepto los <a href="#" class="text-[#4DB6AC] font-bold hover:text-[#273B69] underline transition-colors">Términos</a> y la <a href="#" class="text-[#4DB6AC] font-bold hover:text-[#273B69] underline transition-colors">Política de Privacidad</a>.</span>
            </label>
        </div>

        <div class="pt-2 sm:pt-4 flex justify-center">
            <button type="submit" class="w-full sm:w-3/4 flex justify-center py-3 sm:py-4 px-4 border border-[#273B69] rounded-xl shadow-md text-sm font-bold text-[#273B69] bg-[#D6EEE8] hover:bg-[#273B69] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#273B69] transition-colors uppercase tracking-wider">
                Registrarme
            </button>
        </div>

        <div class="text-center mt-4 sm:mt-6">
            <p class="text-xs sm:text-sm text-gray-600">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="font-bold text-[#273B69] hover:text-[#4DB6AC] transition-colors border-b-2 border-[#4DB6AC]">Inicia Sesión</a>
            </p>
        </div>
    </form>

    <!-- SCRIPT DE VALIDACIÓN DINÁMICA DEL DOCUMENTO -->
    <script>
        const docType = document.getElementById('document_type');
        const docNumber = document.getElementById('document_number');

        // Ajusta las reglas cuando cambian el tipo de documento (DNI, CE, Pasaporte)
        docType.addEventListener('change', function() {
            docNumber.value = ''; // Limpia el campo por seguridad
            
            if (this.value === 'DNI') {
                docNumber.setAttribute('maxlength', '8');
                docNumber.setAttribute('pattern', '[0-9]{8}');
                docNumber.title = "El DNI debe tener exactamente 8 números";
            } else if (this.value === 'CE') {
                docNumber.setAttribute('maxlength', '9');
                docNumber.setAttribute('pattern', '[a-zA-Z0-9]{9}');
                docNumber.title = "El Carné de Extranjería debe tener 9 caracteres";
            } else {
                docNumber.setAttribute('maxlength', '12'); // Pasaporte
                docNumber.removeAttribute('pattern'); 
                docNumber.title = "Ingrese su número de pasaporte";
            }
        });

        // Limita lo que el usuario puede teclear en tiempo real según el documento
        function validateDocument(input) {
            if (docType.value === 'DNI') {
                input.value = input.value.replace(/[^0-9]/g, ''); // Solo números
            } else {
                input.value = input.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase(); // Letras y números sin espacios
            }
        }
    </script>
</x-guest-layout>