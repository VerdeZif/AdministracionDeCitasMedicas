@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-extrabold mb-1" style="color:#22396b">Confirma y paga tu cita</h2>
    <p class="text-sm text-gray-500 mb-6">
        Tu horario está reservado por <span id="cuentaRegresiva" class="font-bold">15:00</span> minutos.
    </p>

    <div class="bg-white rounded-2xl border-2 p-6 shadow-sm space-y-3 text-sm" style="border-color:#4DB6AC">
        <div class="flex justify-between">
            <span class="text-gray-500">Paciente</span>
            <span class="font-semibold">{{ $appointment->dependent?->full_name ?? Auth::user()->name }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Sede</span>
            <span class="font-semibold">{{ $appointment->headquarter->name }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Especialidad</span>
            <span class="font-semibold">{{ $appointment->specialty->name }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Médico</span>
            <span class="font-semibold">{{ $appointment->doctor->name }} {{ $appointment->doctor->last_name_paternal }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Fecha y hora</span>
            <span class="font-semibold">
                {{ \Carbon\Carbon::parse($appointment->date)->locale('es')->translatedFormat('l d \d\e F') }},
                {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
            </span>
        </div>
        <div class="flex justify-between pt-3 border-t border-gray-100 text-lg">
            <span class="font-bold" style="color:#22396b">Total</span>
            <span class="font-extrabold" style="color:#22396b">S/ {{ number_format($appointment->specialty->price, 2) }}</span>
        </div>
    </div>

    <button type="button" onclick="abrirPago()"
            class="w-full mt-6 py-3.5 rounded-md font-bold uppercase tracking-wide text-sm text-white shadow-md"
            style="background:#22396b">
        Pagar S/ {{ number_format($appointment->specialty->price, 2) }}
    </button>

    <form method="POST" action="{{ route('patient.appointments.cancel', $appointment) }}" class="text-center mt-3"
          onsubmit="return confirm('¿Cancelar esta reserva? El horario quedará libre.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm text-red-600 underline font-semibold">Cancelar reserva</button>
    </form>

    <p class="text-xs text-gray-400 mt-3 text-center">Pasarela simulada: no se realiza ningún cobro real.</p>
</div>

@include('patient.payment-modal')

<script>
    const expira = {{ $appointment->created_at->copy()->addMinutes(15)->timestamp }} * 1000;
    const tick = setInterval(() => {
        const resto = Math.max(0, Math.floor((expira - Date.now()) / 1000));
        document.getElementById('cuentaRegresiva').innerText =
            `${String(Math.floor(resto / 60)).padStart(2, '0')}:${String(resto % 60).padStart(2, '0')}`;
        if (resto === 0) {
            clearInterval(tick);
            window.location.href = "{{ route('patient.appointments.create') }}";
        }
    }, 1000);
</script>
@endsection