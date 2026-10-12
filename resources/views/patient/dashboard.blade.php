@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <h2 class="text-3xl font-extrabold text-brand-dark">Mi Historial Médico</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 underline font-semibold text-sm">Cerrar Sesión</button>
        </form>
    </div>

    <div class="mb-8">
        <a href="{{ route('patient.appointments.create') }}" class="bg-brand-action hover:bg-brand-action-hover text-white font-bold py-3 px-6 rounded-lg shadow-md inline-block">
            + Agendar Nueva Cita
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($appointments as $apt)
        <div class="bg-white rounded-lg shadow border border-gray-100 p-6">
            <div class="flex justify-between items-start mb-4">
                <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Confirmada</span>
                <span class="text-brand-dark font-bold">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M') }}</span>
            </div>
            <h3 class="text-lg font-bold text-brand-dark">{{ $apt->specialty->name }}</h3>
            <p class="text-sm opacity-75 mt-1">{{ $apt->doctor->name ?? 'Médico General' }}</p>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</span>
                <a href="{{ route('patient.appointments.pdf', $apt->id) }}" class="text-brand-action text-sm font-semibold underline hover:no-underline">
                    Descargar PDF
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection