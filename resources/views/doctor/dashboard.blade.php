@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <div>
            <h2 class="text-3xl font-extrabold text-brand-dark">Agenda Clínica</h2>
            <p class="opacity-75">Tus pacientes programados para hoy ({{ date('d M Y') }}).</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 underline font-semibold text-sm">Cerrar Sesión</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border-t-4 border-brand-dark">
        @if($appointments->isEmpty())
            <div class="p-8 text-center text-gray-500">No tienes citas programadas para hoy.</div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($appointments as $apt)
                <li class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between hover:bg-gray-50 transition">
                    <div>
                        <span class="text-2xl font-bold text-brand-action mr-4">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}</span>
                        <span class="font-bold text-brand-dark text-lg">{{ $apt->patient->name }}</span>
                        <p class="text-sm opacity-70 mt-1">Especialidad: {{ $apt->specialty->name }}</p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex gap-2">
                        <button class="bg-blue-100 text-blue-700 px-4 py-2 rounded font-semibold text-sm hover:bg-blue-200">Atender</button>
                        <button class="bg-red-100 text-red-700 px-4 py-2 rounded font-semibold text-sm hover:bg-red-200">Ausente</button>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection