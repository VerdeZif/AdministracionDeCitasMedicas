@extends('layouts.app')

@section('content')
@php
    $statusStyles = [
        'Pendiente de Pago' => ['bg' => '#FEF3C7', 'text' => '#92400E'],
        'Confirmada'        => ['bg' => '#DCFCE7', 'text' => '#166534'],
        'En Curso'          => ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
        'Atendida'          => ['bg' => '#E0F2F1', 'text' => '#00695C'],
        'Ausente'           => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
        'Cancelada'         => ['bg' => '#F3F4F6', 'text' => '#374151'],
    ];
    $esHoy         = $date->isToday();
    $noEsFutura    = $date->copy()->startOfDay()->lte(today());
    $fechaNoPasada = $date->copy()->startOfDay()->gte(today());
@endphp

<style>
    .ad-navy { color:#22396b; }
    .ad-card { background:#fff; border:1.5px solid #4DB6AC33; border-radius:1rem; }
    .ad-btn { display:inline-block; color:#fff; font-weight:600; padding:.55rem 1.25rem; border-radius:.6rem; box-shadow:0 2px 6px rgba(0,0,0,.12); transition:filter .15s; }
    .ad-btn:hover { filter:brightness(.92); }
    .ad-btn-sm { display:inline-block; color:#fff; font-weight:600; font-size:.8rem; padding:.4rem .9rem; border-radius:.5rem; box-shadow:0 2px 6px rgba(0,0,0,.12); transition:filter .15s; }
    .ad-btn-sm:hover { filter:brightness(.92); }
    .ad-chip { display:inline-block; padding:.3rem .8rem; border-radius:9999px; font-size:.75rem; font-weight:700; border:1px solid #d1d5db; color:#374151; background:#fff; }
    .ad-input { border:1px solid #d1d5db; border-radius:.5rem; padding:.3rem .6rem; font-size:.8rem; background:#fff; color:#374151; }
    .ad-input:focus { outline:none; border-color:#4DB6AC; box-shadow:0 0 0 2px #4DB6AC33; }
    .ad-field { width:100%; border:1px solid #d1d5db; border-radius:.5rem; padding:.55rem .75rem; font-size:.875rem; background:#fff; }
    .ad-field:focus { outline:none; border-color:#4DB6AC; box-shadow:0 0 0 2px #4DB6AC33; }
    .ad-table th { padding:.9rem 1rem; text-align:left; font-size:.8rem; color:#22396b; background:#f9fafb; border-bottom:1px solid #e5e7eb; }
    .ad-table td { padding:.9rem 1rem; border-bottom:1px solid #f3f4f6; font-size:.875rem; vertical-align:middle; }
    .ad-table tr:hover td { background:#fafafa; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200">
        <div>
            <h2 class="text-3xl font-extrabold ad-navy">Agenda Clínica</h2>
            <p class="text-sm text-gray-500 mt-1">
                Dr(a). {{ auth()->user()->name }} {{ auth()->user()->last_name_paternal }}
                @if(auth()->user()->specialty) · {{ auth()->user()->specialty->name }} @endif
            </p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 underline font-semibold text-sm">Cerrar Sesión</button>
        </form>
    </div>

    {{-- Gestión --}}
    <div class="ad-card p-6 mb-8">
        <h3 class="text-lg font-bold ad-navy mb-4">Gestión de Agenda</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('doctor.bloqueos.index') }}" class="ad-btn" style="background:#22396b">Bloquear horarios</a>
        </div>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#DCFCE7; border:1px solid #BBF7D0; color:#166534">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">{{ $errors->first() }}</div>
    @endif

    {{-- Aviso: citas anteriores sin cerrar --}}
    @if($sinCerrar['total'] > 0)
        <div class="mb-6 rounded-lg p-3 text-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2"
             style="background:#FEF3C7; border:1px solid #FDE68A; color:#92400E">
            <span>
                Tienes <strong>{{ $sinCerrar['total'] }}</strong>
                {{ $sinCerrar['total'] === 1 ? 'cita anterior sin cerrar' : 'citas anteriores sin cerrar' }}.
                Márcalas como atendidas o ausentes.
            </span>
            <a href="{{ route('doctor.dashboard', ['fecha' => \Carbon\Carbon::parse($sinCerrar['desde'])->toDateString()]) }}"
               class="underline font-semibold whitespace-nowrap">Ir a la más antigua</a>
        </div>
    @endif

    {{-- KPIs --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="ad-card p-5" style="border-left:4px solid #22396b">
            <p class="text-xs uppercase tracking-wide text-gray-500">Citas del día</p>
            <p class="text-3xl font-extrabold ad-navy mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="ad-card p-5" style="border-left:4px solid #3B82F6">
            <p class="text-xs uppercase tracking-wide text-gray-500">Por atender</p>
            <p class="text-3xl font-extrabold ad-navy mt-1">{{ $stats['pendientes'] }}</p>
        </div>
        <div class="ad-card p-5" style="border-left:4px solid #4DB6AC">
            <p class="text-xs uppercase tracking-wide text-gray-500">Atendidas</p>
            <p class="text-3xl font-extrabold mt-1" style="color:#4DB6AC">{{ $stats['atendidas'] }}</p>
        </div>
        <div class="ad-card p-5" style="border-left:4px solid #EF4444">
            <p class="text-xs uppercase tracking-wide text-gray-500">Ausentes</p>
            <p class="text-3xl font-extrabold mt-1" style="color:#991B1B">{{ $stats['ausentes'] }}</p>
        </div>
    </div>

    {{-- Citas --}}
    <div class="ad-card overflow-hidden">
        <div class="px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3" style="background:#22396b; color:#fff">
            <div>
                <h3 class="font-bold">Citas del día</h3>
                <p class="text-xs opacity-80">{{ $esHoy ? 'Hoy · ' : '' }}{{ $date->translatedFormat('l d \d\e F Y') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('doctor.dashboard', ['fecha' => $date->copy()->subDay()->toDateString()]) }}" class="ad-chip">← Anterior</a>

                <form method="GET" action="{{ route('doctor.dashboard') }}">
                    <input type="date" name="fecha" value="{{ $date->toDateString() }}" class="ad-input" onchange="this.form.submit()">
                </form>

                <a href="{{ route('doctor.dashboard', ['fecha' => $date->copy()->addDay()->toDateString()]) }}" class="ad-chip">Siguiente →</a>

                @unless($esHoy)
                    <a href="{{ route('doctor.dashboard') }}" class="ad-chip" style="background:#4DB6AC; border-color:#4DB6AC; color:#fff">Hoy</a>
                @endunless
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="ad-table w-full border-collapse">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Especialidad</th>
                        <th>Sede</th>
                        <th>Estado</th>
                        <th style="text-align:right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $apt)
                        @php
                            $estilo = $statusStyles[$apt->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151'];
                            $nombrePaciente = $apt->dependent?->full_name
                                ?? trim($apt->patient?->name . ' ' . $apt->patient?->last_name_paternal);
                            $puedeAtender   = $noEsFutura && $apt->status === 'Confirmada';
                            $puedeFinalizar = $noEsFutura && $apt->status === 'En Curso';
                            $puedeCancelar  = $fechaNoPasada && in_array($apt->status, ['Pendiente de Pago', 'Confirmada']);
                        @endphp
                        <tr style="{{ $apt->status === 'Cancelada' ? 'opacity:.6' : '' }}">
                            <td class="font-semibold">{{ \Carbon\Carbon::parse($apt->time)->format('h:i A') }}</td>
                            <td class="font-medium">
                                {{ $nombrePaciente }}
                                @if($apt->dependent_id)
                                    <span class="block text-xs text-gray-400">
                                        Cuenta de {{ $apt->patient?->name }} {{ $apt->patient?->last_name_paternal }}
                                    </span>
                                @endif
                                @if($apt->patient?->phone)
                                    <span class="block text-xs text-gray-400">Tel. {{ $apt->patient->phone }}</span>
                                @endif
                            </td>
                            <td>{{ $apt->specialty?->name }}</td>
                            <td>{{ $apt->headquarter?->name }}</td>
                            <td>
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold"
                                      style="background:{{ $estilo['bg'] }}; color:{{ $estilo['text'] }}">{{ $apt->status }}</span>

                                @if($apt->status === 'Cancelada' && $apt->cancellation_reason)
                                    <span class="block text-xs text-gray-400 mt-1">
                                        {{ $apt->cancelled_by === 'doctor' ? 'Cancelada por ti' : 'Cancelada por el paciente' }}: {{ $apt->cancellation_reason }}
                                    </span>
                                @endif
                                @if($apt->status === 'Atendida' && $apt->follow_up_date)
                                    <span class="block text-xs text-gray-400 mt-1">
                                        Control: {{ \Carbon\Carbon::parse($apt->follow_up_date)->format('d/m/Y') }}
                                    </span>
                                @endif
                            </td>
                            <td style="text-align:right; white-space:nowrap">
                                @if($puedeAtender)
                                    <form method="POST" action="{{ route('doctor.appointments.start', $apt) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="ad-btn-sm" style="background:#4DB6AC">Atender</button>
                                    </form>
                                    <form method="POST" action="{{ route('doctor.appointments.absent', $apt) }}" class="inline"
                                          onsubmit="return confirm('¿Marcar al paciente como ausente?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="ad-btn-sm" style="background:#374151">Ausente</button>
                                    </form>
                                @endif

                                @if($puedeFinalizar)
                                    <button type="button" class="ad-btn-sm" style="background:#22396b"
                                            data-action="{{ route('doctor.appointments.finish', $apt) }}"
                                            data-patient="{{ $nombrePaciente }}"
                                            onclick="abrirFinalizar(this)">Finalizar consulta</button>
                                @endif

                                @if($puedeCancelar)
                                    <button type="button" class="ad-btn-sm" style="background:#dc2626"
                                            data-action="{{ route('doctor.appointments.cancel', $apt) }}"
                                            data-patient="{{ $nombrePaciente }}"
                                            onclick="abrirCancelar(this)">Cancelar</button>
                                @endif

                                @if(!$puedeAtender && !$puedeFinalizar && !$puedeCancelar)
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-gray-500" style="padding:2.5rem">No tienes citas programadas para este día.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal: finalizar consulta --}}
<div id="modalFinalizar" class="hidden" style="position:fixed; inset:0; z-index:9999; background:rgba(17,24,39,.6); overflow-y:auto;">
    <div style="min-height:100%; display:flex; align-items:center; justify-content:center; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full relative p-6" style="max-width:36rem;">
            <button type="button" onclick="cerrarModal('modalFinalizar')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">✖</button>
            <h3 class="text-xl font-bold ad-navy mb-1">Finalizar consulta</h3>
            <p class="text-sm text-gray-500 mb-4">Paciente: <span id="finalizarPaciente" class="font-semibold"></span></p>

            <form id="formFinalizar" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <input type="hidden" name="_modal" value="finish">
                <input type="hidden" name="_action" id="finalizarAction">
                <input type="hidden" name="_patient" id="finalizarPacienteInput">

                <div>
                    <label class="block text-xs font-medium mb-1">Diagnóstico</label>
                    <textarea name="diagnosis" rows="3" required minlength="5" maxlength="2000" class="ad-field">{{ old('diagnosis') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Indicaciones / tratamiento</label>
                    <textarea name="instructions" rows="4" required minlength="5" maxlength="2000" class="ad-field">{{ old('instructions') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Fecha de control (opcional)</label>
                    <input type="date" name="follow_up_date" value="{{ old('follow_up_date') }}" min="{{ today()->addDay()->toDateString() }}" class="ad-field">
                </div>
                <p class="text-xs text-gray-400">El paciente podrá ver este registro en su panel.</p>
                <button type="submit" class="ad-btn w-full" style="background:#22396b">Guardar y finalizar</button>
            </form>
        </div>
    </div>
</div>

{{-- Modal: cancelar cita --}}
<div id="modalCancelar" class="hidden" style="position:fixed; inset:0; z-index:9999; background:rgba(17,24,39,.6); overflow-y:auto;">
    <div style="min-height:100%; display:flex; align-items:center; justify-content:center; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full relative p-6" style="max-width:28rem;">
            <button type="button" onclick="cerrarModal('modalCancelar')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">✖</button>
            <h3 class="text-xl font-bold ad-navy mb-1">Cancelar cita</h3>
            <p class="text-sm text-gray-500 mb-4">Paciente: <span id="cancelarPaciente" class="font-semibold"></span></p>

            <form id="formCancelar" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <input type="hidden" name="_modal" value="cancel">
                <input type="hidden" name="_action" id="cancelarAction">
                <input type="hidden" name="_patient" id="cancelarPacienteInput">

                <div>
                    <label class="block text-xs font-medium mb-1">Motivo de la cancelación</label>
                    <textarea name="reason" rows="3" required minlength="5" maxlength="255" class="ad-field">{{ old('reason') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">El paciente verá este motivo en su panel. Si ya pagó, la cita quedará pendiente de reembolso.</p>
                </div>
                <button type="submit" class="ad-btn w-full" style="background:#dc2626">Confirmar cancelación</button>
            </form>
        </div>
    </div>
</div>

<script>
    function abrirModal(id)  { document.getElementById(id).classList.remove('hidden'); }
    function cerrarModal(id) { document.getElementById(id).classList.add('hidden'); }

    function prepararFinalizar(action, paciente) {
        document.getElementById('formFinalizar').action = action;
        document.getElementById('finalizarAction').value = action;
        document.getElementById('finalizarPacienteInput').value = paciente || '';
        document.getElementById('finalizarPaciente').textContent = paciente || '';
        abrirModal('modalFinalizar');
    }
    function prepararCancelar(action, paciente) {
        document.getElementById('formCancelar').action = action;
        document.getElementById('cancelarAction').value = action;
        document.getElementById('cancelarPacienteInput').value = paciente || '';
        document.getElementById('cancelarPaciente').textContent = paciente || '';
        abrirModal('modalCancelar');
    }

    function abrirFinalizar(btn) { prepararFinalizar(btn.dataset.action, btn.dataset.patient); }
    function abrirCancelar(btn)  { prepararCancelar(btn.dataset.action, btn.dataset.patient); }

    // Si el formulario falló al validar, reabrimos el modal con lo que escribió el médico
    @if($errors->any() && old('_modal') === 'finish')
        prepararFinalizar(@json(old('_action')), @json(old('_patient')));
    @endif
    @if($errors->any() && old('_modal') === 'cancel')
        prepararCancelar(@json(old('_action')), @json(old('_patient')));
    @endif
</script>
@endsection