@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <h2 class="text-3xl font-extrabold text-brand-dark">Panel Administrativo</h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 font-semibold py-2 px-4 rounded-lg transition border border-red-200 text-sm">Cerrar Sesión</button>
        </form>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-brand-action">
            <h3 class="text-sm font-semibold opacity-70 uppercase tracking-wide">Citas Totales</h3>
            <p class="text-3xl font-bold text-brand-dark">{{ $appointments->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-brand-dark">
            <h3 class="text-sm font-semibold opacity-70 uppercase tracking-wide">Ingresos Procesados</h3>
            <p class="text-3xl font-bold text-brand-action">S/ {{ number_format($totalIngresos ?? 0, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
            <h3 class="text-sm font-semibold opacity-70 uppercase tracking-wide">Sedes Activas</h3>
            <p class="text-3xl font-bold text-brand-dark">{{ \App\Models\Headquarter::count() }}</p>
        </div>
    </div>

    <!-- Tabla Auditoría -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-brand-dark text-white px-6 py-4">
            <h3 class="font-bold">Auditoría de Citas Recientes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-sm font-semibold text-brand-dark">
                        <th class="p-4">Fecha</th>
                        <th class="p-4">Paciente</th>
                        <th class="p-4">Especialidad</th>
                        <th class="p-4">Estado</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($appointments->take(10) as $apt)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="p-4">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M Y') }}</td>
                        <td class="p-4 font-medium">{{ $apt->patient->name }}</td>
                        <td class="p-4">{{ $apt->specialty->name }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Confirmada</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection