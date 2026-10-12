@extends('layouts.app')

@section('content')
<style>
    .cal-nav { width:2.25rem; height:2.25rem; border-radius:9999px; border:1px solid #4DB6AC; color:#22396b; font-size:1.25rem; line-height:1; }
    .cal-nav:disabled { opacity:.35; cursor:not-allowed; }
    .cal-day { border:1px solid #4DB6AC; border-radius:.6rem; padding:.5rem .25rem; text-align:center; background:#fff; transition:.15s; }
    .cal-day:hover:not(:disabled) { background:#E0F2F1; }
    .cal-day.selected { background:#22396b; border-color:#22396b; color:#fff; }
    .cal-day:disabled { border-color:#e5e7eb; color:#cbd5e1; background:#f9fafb; cursor:not-allowed; }
    .cal-num { display:block; font-weight:700; font-size:1.1rem; }
    .cal-sub { display:block; font-size:.65rem; margin-top:2px; }
    .hora-btn { border:1px solid #22396b; color:#22396b; font-weight:600; padding:.5rem; border-radius:.4rem; transition:.15s; }
    .hora-btn:hover { background:#22396b; color:#fff; }
    .sel-line { width:100%; border:0; border-bottom:1px solid #4DB6AC; padding:.25rem 0; background:transparent; font-size:.875rem; color:#374151; }
    .sel-line:focus { outline:none; box-shadow:none; }
</style>

<div class="max-w-6xl mx-auto px-4 py-10">
    <form action="{{ route('patient.appointments.store') }}" method="POST" id="appointmentForm">
        @csrf

        @if($errors->any())
            <div class="mb-6 rounded-lg p-3 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">

            {{-- Izquierda: datos --}}
            <div class="lg:col-span-4 border-2 rounded-[20px] p-6 bg-white shadow-sm" style="border-color:#4DB6AC;">
                <h3 class="text-lg font-bold text-brand-dark mb-6 uppercase tracking-wide">Completar los datos</h3>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿Para quién es la cita?</label>
                        <select id="patient_type" name="patient_type" onchange="toggleDependentFields(); actualizarResumen();" class="sel-line font-medium">
                            <option value="titular" selected>{{ Auth::user()->name }} (Titular)</option>
                            <option value="dependiente">Agregar a un Familiar / Tercero</option>
                        </select>
                    </div>

                    <div id="dependent_fields" class="hidden bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-brand-dark mb-1">Nombre del Familiar</label>
                            <input type="text" id="dependent_name" name="dependent_name" onkeyup="actualizarResumen()" placeholder="Ej. María Pérez" class="sel-line">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-brand-dark mb-1">DNI del Familiar</label>
                            <input type="text" id="dependent_dni" name="dependent_dni" placeholder="Número de documento" class="sel-line">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿En cuál Sede?</label>
                        <select id="headquarter_id" name="headquarter_id" onchange="actualizarResumen()" required class="sel-line uppercase">
                            <option value="">-- SELECCIONE SEDE --</option>
                            @foreach($headquarters as $hq)
                                <option value="{{ $hq->id }}">{{ $hq->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿Cuál Especialidad?</label>
                        <select id="specialty_id" name="specialty_id" onchange="onFiltroCambiado()" required class="sel-line uppercase">
                            <option value="" data-price="0.00">-- SELECCIONE ESPECIALIDAD --</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}" data-price="{{ number_format($specialty->price, 2) }}">
                                    {{ $specialty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-brand-dark mb-1">¿Tienes un Médico favorito?</label>
                        <select id="doctor_id" name="doctor_id" onchange="onFiltroCambiado()" class="sel-line uppercase">
                            <option value="">CUALQUIER MÉDICO DISPONIBLE</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" data-specialty="{{ $doctor->specialty_id }}">
                                    {{ $doctor->name }} {{ $doctor->last_name_paternal }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Derecha: calendario --}}
            <div class="lg:col-span-8 border-2 rounded-[20px] p-6 bg-white shadow-sm flex flex-col" style="border-color:#4DB6AC;">
                <h3 class="text-lg font-bold text-brand-dark mb-4 uppercase tracking-wide">Selecciona tu turno</h3>

                <div class="flex items-center justify-between mb-4">
                    <button type="button" id="btnPrevMes" onclick="cambiarMes(-1)" class="cal-nav">‹</button>
                    <span id="tituloMes" class="font-bold text-brand-dark capitalize"></span>
                    <button type="button" onclick="cambiarMes(1)" class="cal-nav">›</button>
                </div>

                <div class="grid grid-cols-7 gap-2 text-center text-xs uppercase text-gray-500 mb-2">
                    <span>Lun</span><span>Mar</span><span>Mié</span><span>Jue</span><span>Vie</span><span>Sáb</span><span>Dom</span>
                </div>
                <div id="gridCalendario" class="grid grid-cols-7 gap-2"></div>
                <p id="avisoCalendario" class="text-sm text-gray-500 mt-4"></p>

                <input type="hidden" id="selected_date" name="date" required>
                <input type="hidden" id="selected_time" name="time" required>
            </div>
        </div>

        {{-- Resumen --}}
        <div class="max-w-4xl">
            <h4 class="text-lg mb-2 font-bold" style="color:#4DB6AC;">Resumen de Reserva</h4>

            <div class="border-[1.5px] border-dashed border-brand-dark rounded-xl p-5 mb-4 bg-white shadow-sm">
                <div class="space-y-3 text-[13px] text-brand-dark font-medium uppercase">
                    <div class="flex items-center gap-3">
                        <span class="w-5 flex justify-center opacity-60">👤</span>
                        <span class="font-bold">PACIENTE:</span>
                        <span id="resumen_paciente" style="color:#4DB6AC">{{ Auth::user()->name }} [TITULAR]</span>
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
                            <span id="resumen_turno" class="font-bold" style="color:#EF4444">SELECCIONA FECHA Y HORA</span>
                        </div>
                        <div class="text-3xl font-bold mt-4 sm:mt-0 text-brand-dark tracking-tight normal-case">
                            S/ <span id="resumen_precio">0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" id="btnSubmit"
                    class="w-full text-white font-bold py-3.5 rounded-md uppercase tracking-wide text-sm shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                    style="background:#22396b">
                Continuar al pago
            </button>
        </div>
    </form>
</div>

{{-- Modal de horarios --}}
<div id="modalHorarios" class="hidden fixed inset-0 z-50 flex items-center justify-center" style="background:rgba(17,24,39,.55)">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 relative">
        <button onclick="cerrarModal()" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">✖</button>
        <h3 class="text-xl font-bold text-brand-dark mb-1">Horarios Disponibles</h3>
        <p id="modalFechaTexto" class="text-sm font-semibold mb-6" style="color:#4DB6AC">Seleccionando fecha...</p>
        <div class="grid grid-cols-2 gap-3" id="contenedorHoras"></div>
    </div>
</div>

<script>
    const authUserName = @json(Auth::user()->name);
    const modal = document.getElementById('modalHorarios');
    const pad = n => String(n).padStart(2, '0');
    const hoy = new Date(); hoy.setHours(0, 0, 0, 0);

    let mesActual = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
    let disponibilidad = {};
    let fechaSeleccionada = '';
    let fechaTemporal = '';

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
            document.getElementById('resumen_paciente').innerText = authUserName + ' [TITULAR]';
        } else {
            const depName = document.getElementById('dependent_name').value;
            document.getElementById('resumen_paciente').innerText = (depName ? depName.toUpperCase() : 'NOMBRE PENDIENTE') + ' [FAMILIAR]';
        }

        const sede = document.getElementById('headquarter_id');
        document.getElementById('resumen_sede').innerText = sede.value ? sede.options[sede.selectedIndex].text : 'PENDIENTE...';

        const esp = document.getElementById('specialty_id');
        document.getElementById('resumen_especialidad').innerText = esp.value ? esp.options[esp.selectedIndex].text : 'PENDIENTE...';
        document.getElementById('resumen_precio').innerText = esp.value ? esp.options[esp.selectedIndex].getAttribute('data-price') : '0.00';

        const doc = document.getElementById('doctor_id');
        document.getElementById('resumen_medico').innerText = doc.value ? doc.options[doc.selectedIndex].text : 'CUALQUIERA DISPONIBLE';

        validarFormulario();
    }

    function filtrarMedicos() {
        const esp = document.getElementById('specialty_id').value;
        const sel = document.getElementById('doctor_id');
        [...sel.options].forEach(o => {
            if (!o.value) return;
            const ok = !esp || o.dataset.specialty === esp;
            o.hidden = !ok;
            o.disabled = !ok;
        });
        if (sel.selectedOptions[0]?.disabled) sel.value = '';
    }

    function onFiltroCambiado() {
        // Al cambiar especialidad o médico se descarta el turno elegido
        fechaSeleccionada = '';
        document.getElementById('selected_date').value = '';
        document.getElementById('selected_time').value = '';
        const t = document.getElementById('resumen_turno');
        t.innerText = 'SELECCIONA FECHA Y HORA';
        t.style.color = '#EF4444';
        filtrarMedicos();
        cargarMes();
        actualizarResumen();
    }

    function cambiarMes(delta) {
        mesActual = new Date(mesActual.getFullYear(), mesActual.getMonth() + delta, 1);
        cargarMes();
    }

    async function cargarMes() {
        const y = mesActual.getFullYear(), m = mesActual.getMonth();
        document.getElementById('tituloMes').innerText =
            mesActual.toLocaleDateString('es-PE', { month: 'long', year: 'numeric' });
        document.getElementById('btnPrevMes').disabled = (y === hoy.getFullYear() && m === hoy.getMonth());

        const esp = document.getElementById('specialty_id').value;
        const aviso = document.getElementById('avisoCalendario');
        if (!esp) {
            disponibilidad = {};
            aviso.innerText = 'Primero selecciona una especialidad para ver los días disponibles.';
            dibujarCalendario();
            return;
        }

        aviso.innerText = 'Buscando disponibilidad...';
        const params = new URLSearchParams({
            month: `${y}-${pad(m + 1)}`,
            specialty_id: esp,
            doctor_id: document.getElementById('doctor_id').value
        });
        try {
            const res = await fetch(`/api/disponibilidad-mes?${params}`, { headers: { 'Accept': 'application/json' } });
            disponibilidad = await res.json();
            aviso.innerText = '';
        } catch (e) {
            disponibilidad = {};
            aviso.innerText = 'No se pudo cargar la disponibilidad.';
        }
        dibujarCalendario();
    }

    function dibujarCalendario() {
        const grid = document.getElementById('gridCalendario');
        grid.innerHTML = '';
        const y = mesActual.getFullYear(), m = mesActual.getMonth();
        const offset = (new Date(y, m, 1).getDay() + 6) % 7; // lunes = 0
        const dias = new Date(y, m + 1, 0).getDate();
        const hayEsp = !!document.getElementById('specialty_id').value;

        for (let i = 0; i < offset; i++) grid.appendChild(document.createElement('div'));

        for (let d = 1; d <= dias; d++) {
            const fecha = `${y}-${pad(m + 1)}-${pad(d)}`;
            const fechaObj = new Date(y, m, d);
            const libres = disponibilidad[fecha] || 0;
            const pasado = fechaObj < hoy;
            const habilitado = hayEsp && !pasado && libres > 0;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.disabled = !habilitado;
            btn.className = 'cal-day' + (fecha === fechaSeleccionada ? ' selected' : '');
            btn.innerHTML = `<span class="cal-num">${d}</span><span class="cal-sub">${
                habilitado ? libres + ' libres' : (pasado || !hayEsp ? '&nbsp;' : 'Sin cupos')
            }</span>`;
            btn.onclick = () => abrirModalHorarios(
                fecha,
                fechaObj.toLocaleDateString('es-PE', { weekday: 'long', day: 'numeric', month: 'long' })
            );
            grid.appendChild(btn);
        }
    }

    async function abrirModalHorarios(fechaIso, fechaTexto) {
        fechaTemporal = fechaIso;
        document.getElementById('modalFechaTexto').innerText = fechaTexto;
        const contenedor = document.getElementById('contenedorHoras');
        contenedor.innerHTML = '<p class="col-span-2 text-center text-sm text-gray-500">Buscando disponibilidad...</p>';
        modal.classList.remove('hidden');

        const params = new URLSearchParams({
            date: fechaIso,
            specialty_id: document.getElementById('specialty_id').value,
            doctor_id: document.getElementById('doctor_id').value
        });
        try {
            const res = await fetch(`/api/horarios-disponibles?${params}`, { headers: { 'Accept': 'application/json' } });
            const horas = await res.json();
            if (!res.ok || !Array.isArray(horas)) {
                contenedor.innerHTML = `<p class="col-span-2 text-center text-sm text-red-500">${horas.message || 'Error ' + res.status}</p>`;
                return;
            }
contenedor.innerHTML = '';
            horas.forEach(hora => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'hora-btn';
                btn.innerText = hora;
                btn.onclick = () => seleccionarHora(hora);
                contenedor.appendChild(btn);
            });
        } catch (e) {
            contenedor.innerHTML = '<p class="col-span-2 text-center text-sm text-red-500">Error al conectar con el servidor.</p>';
        }
    }

    function cerrarModal() {
        modal.classList.add('hidden');
    }

    function seleccionarHora(hora) {
        fechaSeleccionada = fechaTemporal;
        document.getElementById('selected_date').value = fechaTemporal;
        document.getElementById('selected_time').value = hora;
        const t = document.getElementById('resumen_turno');
        t.innerText = `${fechaTemporal} a las ${hora} horas`;
        t.style.color = '#22396b';
        cerrarModal();
        dibujarCalendario();
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
        filtrarMedicos();
        actualizarResumen();
        cargarMes();
    };
</script>
@endsection