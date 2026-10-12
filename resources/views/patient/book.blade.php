@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <form action="{{ route('patient.appointments.store') }}" method="POST" id="appointmentForm">
        @csrf
        
        <!-- Contenedor Superior: Dos Columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
            
            <!-- Izquierda: COMPLETAR LOS DATOS -->
            <div class="lg:col-span-4 border-2 rounded-[20px] p-6 bg-white shadow-sm relative" style="border-color: #4DB6AC;">
                <h3 class="text-lg font-bold text-brand-dark mb-6 uppercase tracking-wide">Completar los datos</h3>
                
                <div class="space-y-6">
                    <!-- Selección de Paciente -->
                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿Para quién es la cita?</label>
                        <select id="patient_type" name="patient_type" onchange="toggleDependentFields(); actualizarResumen();" class="w-full border-0 border-b border-brand-action focus:ring-0 px-0 py-1 bg-transparent text-sm text-gray-700 font-medium">
                            <option value="titular" selected>{{ Auth::user()->name }} (Titular)</option>
                            <option value="dependiente">Agregar a un Familiar / Tercero</option>
                        </select>
                    </div>

                    <!-- Campos ocultos para el familiar -->
                    <div id="dependent_fields" class="hidden bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-brand-dark mb-1">Nombre del Familiar</label>
                            <input type="text" id="dependent_name" name="dependent_name" onkeyup="actualizarResumen()" placeholder="Ej. María Pérez" class="w-full border-0 border-b border-gray-300 focus:border-brand-action focus:ring-0 px-0 py-1 bg-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-brand-dark mb-1">DNI del Familiar</label>
                            <input type="text" id="dependent_dni" name="dependent_dni" placeholder="Número de documento" class="w-full border-0 border-b border-gray-300 focus:border-brand-action focus:ring-0 px-0 py-1 bg-transparent text-sm">
                        </div>
                    </div>

                    <!-- Sedes (PHP Nativo) -->
                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿En cuál Sede?</label>
                        <select id="headquarter_id" name="headquarter_id" onchange="actualizarResumen()" required class="w-full border-0 border-b border-brand-action focus:ring-0 px-0 py-1 bg-transparent text-sm uppercase text-gray-700">
                            <option value="">-- SELECCIONE SEDE --</option>
                            <?php foreach($headquarters as$hq): ?>
                                <option value="{{ $hq->id }}">{{ $hq->name }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Especialidades (PHP Nativo) -->
                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿Cuál Especialidad?</label>
                        <select id="specialty_id" name="specialty_id" onchange="actualizarResumen()" required class="w-full border-0 border-b border-brand-action focus:ring-0 px-0 py-1 bg-transparent text-sm uppercase text-gray-700">
                            <option value="" data-price="0.00">-- SELECCIONE ESPECIALIDAD --</option>
                            <?php foreach($specialties as$specialty): ?>
                                <option value="{{ $specialty->id }}" data-price="{{ number_format($specialty->price, 2) }}">
                                    {{ $specialty->name }}
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Médico (PHP Nativo) -->
                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿Tienes un Médico favorito?</label>
                        <select id="doctor_id" name="doctor_id" onchange="actualizarResumen()" class="w-full border-0 border-b border-brand-action focus:ring-0 px-0 py-1 bg-transparent text-sm text-gray-700 uppercase">
                            <option value="">CUALQUIER MÉDICO DISPONIBLE</option>
                            <?php foreach($doctors as$doctor): ?>
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Derecha: SELECCIONA TU TURNO (Cronograma) -->
            <div class="lg:col-span-8 border-2 rounded-[20px] p-6 bg-white shadow-sm flex flex-col" style="border-color: #4DB6AC;">
                <h3 class="text-lg font-bold text-brand-dark mb-4 uppercase tracking-wide">Selecciona tu turno</h3>
                <p class="text-sm text-gray-500 mb-6">Elige una fecha disponible en el calendario para ver los horarios.</p>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3">
                    <div onclick="abrirModalHorarios('2026-10-12', 'Lunes 12 de Octubre')" class="border border-brand-action rounded-lg p-3 text-center cursor-pointer hover:bg-brand-light transition group">
                        <span class="block text-xs uppercase text-gray-500 group-hover:text-brand-dark">LUN</span>
                        <span class="block text-xl font-bold text-brand-dark">12</span>
                        <span class="block text-xs font-semibold text-brand-action mt-1">Disponible</span>
                    </div>
                    <div onclick="abrirModalHorarios('2026-10-13', 'Martes 13 de Octubre')" class="border border-brand-action rounded-lg p-3 text-center cursor-pointer hover:bg-brand-light transition group">
                        <span class="block text-xs uppercase text-gray-500 group-hover:text-brand-dark">MAR</span>
                        <span class="block text-xl font-bold text-brand-dark">13</span>
                        <span class="block text-xs font-semibold text-brand-action mt-1">Disponible</span>
                    </div>
                    <div onclick="abrirModalHorarios('2026-10-14', 'Miércoles 14 de Octubre')" class="border border-brand-action rounded-lg p-3 text-center cursor-pointer hover:bg-brand-light transition group">
                        <span class="block text-xs uppercase text-gray-500 group-hover:text-brand-dark">MIE</span>
                        <span class="block text-xl font-bold text-brand-dark">14</span>
                        <span class="block text-xs font-semibold text-brand-action mt-1">Disponible</span>
                    </div>
                    <div onclick="abrirModalHorarios('2026-10-15', 'Jueves 15 de Octubre')" class="border border-brand-action rounded-lg p-3 text-center cursor-pointer hover:bg-brand-light transition group">
                        <span class="block text-xs uppercase text-gray-500 group-hover:text-brand-dark">JUE</span>
                        <span class="block text-xl font-bold text-brand-dark">15</span>
                        <span class="block text-xs font-semibold text-brand-action mt-1">Disponible</span>
                    </div>
                    <div onclick="abrirModalHorarios('2026-10-16', 'Viernes 16 de Octubre')" class="border border-brand-action rounded-lg p-3 text-center cursor-pointer hover:bg-brand-light transition group">
                        <span class="block text-xs uppercase text-gray-500 group-hover:text-brand-dark">VIE</span>
                        <span class="block text-xl font-bold text-brand-dark">16</span>
                        <span class="block text-xs font-semibold text-brand-action mt-1">Disponible</span>
                    </div>
                </div>

                <input type="hidden" id="selected_date" name="date" required>
                <input type="hidden" id="selected_time" name="time" required>
                <input type="hidden" name="payment_method" value="tarjeta_credito"> 
            </div>
        </div>

        <!-- Resumen de Reserva -->
        <div class="max-w-4xl">
            <h4 class="text-lg mb-2 font-bold" style="color: #4DB6AC;">Resumen de Reserva</h4>
            
            <div class="border-[1.5px] border-dashed border-brand-dark rounded-xl p-5 relative mb-4 bg-white shadow-sm">
                <div class="space-y-3 text-[13px] text-brand-dark font-medium uppercase">
                    <div class="flex items-center gap-3">
                        <span class="w-5 flex justify-center opacity-60">👤</span>
                        <span class="font-bold">PACIENTE:</span> 
                        <span id="resumen_paciente" class="text-brand-action">{{ Auth::user()->name }} [TITULAR]</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-5 flex justify-center opacity-60">🏥</span>
                        <span class="font-bold">SEDE:</span> 
                        <span id="resumen_sede" class="text-gray-500">PENDIENTE...</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-5 flex justify-center opacity-60">⚕️</span>
                        <span class="font-bold">ESPECIALIDAD:</span> 
                        <span id="resumen_especialidad" class="text-gray-500">PENDIENTE...</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-5 flex justify-center opacity-60">👨‍⚕️</span>
                        <span class="font-bold">MÉDICO:</span> 
                        <span id="resumen_medico" class="text-gray-500">CUALQUIERA DISPONIBLE</span>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mt-2 pt-1 border-t border-gray-100">
                        <div class="flex items-center gap-3 mt-3">
                            <span class="w-5 flex justify-center opacity-60">🕒</span>
                            <span class="font-bold">TURNO:</span> 
                            <span id="resumen_turno" class="text-red-500 font-bold">SELECCIONA FECHA Y HORA</span>
                        </div>
                        <div class="text-3xl font-bold mt-4 sm:mt-0 text-brand-dark tracking-tight normal-case">
                            S/ <span id="resumen_precio">0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" id="btnSubmit" class="w-full bg-brand-dark hover:bg-blue-900 text-white font-bold py-3.5 rounded-md transition-colors uppercase tracking-wide text-sm shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                Confirmar y Pagar
            </button>
        </div>
    </form>
</div>

<!-- Modal -->
<div id="modalHorarios" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all relative">
        <button onclick="cerrarModal()" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">
            ✖
        </button>
        <h3 class="text-xl font-bold text-brand-dark mb-1">Horarios Disponibles</h3>
        <p id="modalFechaTexto" class="text-sm text-brand-action font-semibold mb-6">Seleccionando fecha...</p>
        <div class="grid grid-cols-2 gap-3" id="contenedorHoras"></div>
    </div>
</div>

<script>
    const authUserName = "{{ Auth::user()->name }}";
    
    function toggleDependentFields() {
        const type = document.getElementById('patient_type').value;
        const fields = document.getElementById('dependent_fields');
        if (type === 'dependiente') {
            fields.classList.remove('hidden');
        } else {
            fields.classList.add('hidden');
            document.getElementById('dependent_name').value = '';
            document.getElementById('dependent_dni').value = '';
        }
    }

    function actualizarResumen() {
        const type = document.getElementById('patient_type').value;
        if (type === 'titular') {
            document.getElementById('resumen_paciente').innerText = authUserName + " [TITULAR]";
        } else {
            const depName = document.getElementById('dependent_name').value;
            document.getElementById('resumen_paciente').innerText = (depName ? depName.toUpperCase() : "NOMBRE PENDIENTE") + " [FAMILIAR]";
        }

        const sedeSelect = document.getElementById('headquarter_id');
        document.getElementById('resumen_sede').innerText = sedeSelect.value ? sedeSelect.options[sedeSelect.selectedIndex].text : "PENDIENTE...";

        const espSelect = document.getElementById('specialty_id');
        document.getElementById('resumen_especialidad').innerText = espSelect.value ? espSelect.options[espSelect.selectedIndex].text : "PENDIENTE...";
        document.getElementById('resumen_precio').innerText = espSelect.value ? espSelect.options[espSelect.selectedIndex].getAttribute('data-price') : "0.00";

        const docSelect = document.getElementById('doctor_id');
        document.getElementById('resumen_medico').innerText = docSelect.value ? docSelect.options[docSelect.selectedIndex].text : "CUALQUIERA DISPONIBLE";
        
        validarFormulario();
    }

    const modal = document.getElementById('modalHorarios');
    let fechaTemporal = "";

    async function abrirModalHorarios(fechaIso, fechaTexto) {
        fechaTemporal = fechaIso;
        document.getElementById('modalFechaTexto').innerText = fechaTexto;
        
        const doctorId = document.getElementById('doctor_id').value;
        const contenedor = document.getElementById('contenedorHoras');
        
        // Mostrar estado de carga
        contenedor.innerHTML = '<p class="col-span-2 text-center text-sm text-gray-500">Buscando disponibilidad...</p>';
        modal.classList.remove('hidden');

        try {
            // Consultamos al servidor en tiempo real
            const response = await fetch(`/api/horarios-disponibles?date=${fechaIso}&doctor_id=${doctorId}`);
            const horasDisponibles = await response.json();
            
            contenedor.innerHTML = ''; // Limpiamos el mensaje de carga
            
            if (horasDisponibles.length === 0) {
                contenedor.innerHTML = '<p class="col-span-2 text-center text-sm font-bold text-red-500">Agenda llena para este día.</p>';
                return;
            }
            
            // Dibujamos solo los botones de las horas libres
            horasDisponibles.forEach(hora => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'border border-brand-dark text-brand-dark hover:bg-brand-dark hover:text-white font-semibold py-2 rounded transition-colors';
                btn.innerText = hora;
                btn.onclick = () => seleccionarHora(hora);
                contenedor.appendChild(btn);
            });
        } catch (error) {
            contenedor.innerHTML = '<p class="col-span-2 text-center text-sm text-red-500">Error al conectar con el servidor.</p>';
        }
    }

    function cerrarModal() {
        modal.classList.add('hidden');
    }

    function seleccionarHora(hora) {
        document.getElementById('selected_date').value = fechaTemporal;
        document.getElementById('selected_time').value = hora;
        
        document.getElementById('resumen_turno').innerText = `${fechaTemporal} a las ${hora} horas`;
        document.getElementById('resumen_turno').classList.remove('text-red-500');
        document.getElementById('resumen_turno').classList.add('text-brand-dark');
        
        cerrarModal();
        validarFormulario();
    }

    function validarFormulario() {
        const btn = document.getElementById('btnSubmit');
        const sede = document.getElementById('headquarter_id').value;
        const esp = document.getElementById('specialty_id').value;
        const fecha = document.getElementById('selected_date').value;
        const hora = document.getElementById('selected_time').value;

        btn.disabled = !(sede && esp && fecha && hora);
    }

    window.onload = () => {
        actualizarResumen();
        validarFormulario();
    };
</script>
@endsection