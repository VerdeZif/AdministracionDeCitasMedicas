@extends('layouts.app')

@section('content')
@php
    $statusStyles = [
        'Pendiente de Pago' => ['bg' => '#FEF3C7', 'text' => '#92400E'],
        'Confirmada'        => ['bg' => '#DCFCE7', 'text' => '#166534'],
        'En Curso'          => ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
        'Atendida'          => ['bg' => '#E0F2F1', 'text' => '#00695C'],
        'Ausente'           => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
    ];
    $estados = array_keys($statusStyles);
@endphp

<style>
    .ad-navy { color:#22396b; }
    .ad-card { background:#fff; border:1.5px solid #4DB6AC33; border-radius:1rem; }
    .ad-btn { display:inline-block; color:#fff; font-weight:600; padding:.55rem 1.25rem; border-radius:.6rem; box-shadow:0 2px 6px rgba(0,0,0,.12); transition:filter .15s; }
    .ad-btn:hover { filter:brightness(.92); }
    .ad-chip { display:inline-block; padding:.3rem .8rem; border-radius:9999px; font-size:.75rem; font-weight:700; border:1px solid #d1d5db; color:#374151; background:#fff; }
    .ad-chip.activo { background:#22396b; border-color:#22396b; color:#fff; }
    .ad-table th { padding:.9rem 1rem; text-align:left; font-size:.8rem; color:#22396b; background:#f9fafb; border-bottom:1px solid #e5e7eb; }
    .ad-table td { padding:.9rem 1rem; border-bottom:1px solid #f3f4f6; font-size:.875rem; }
    .ad-table tr:hover td { background:#fafafa; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-200">
        <div>
            <h2 class="text-3xl font-extrabold ad-navy">Panel Administrativo</h2>
            <p class="text-sm text-gray-500 mt-1">Resumen general de la clínica.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-600 underline font-semibold text-sm">Cerrar Sesión</button>
        </form>
    </div>

    {{-- Gestión --}}
    <div class="ad-card p-6 mb-8">
        <h3 class="text-lg font-bold ad-navy mb-4">Gestión de Clínica</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.especialidades.index') }}" class="ad-btn" style="background:#4DB6AC">Especialidades</a>
            <a href="{{ route('admin.medicos.index') }}" class="ad-btn" style="background:#22396b">Médicos</a>
            <a href="{{ route('admin.sedes.index') }}" class="ad-btn" style="background:#374151">Sedes</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#DCFCE7; border:1px solid #BBF7D0; color:#166534">{{ session('success') }}</div>
    @endif

    {{-- KPIs --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="ad-card p-5" style="border-left:4px solid #22396b">
            <p class="text-xs uppercase tracking-wide text-gray-500">Citas totales</p>
            <p class="text-3xl font-extrabold ad-navy mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="ad-card p-5" style="border-left:4px solid #4DB6AC">
            <p class="text-xs uppercase tracking-wide text-gray-500">Ingresos procesados</p>
            <p class="text-3xl font-extrabold mt-1" style="color:#4DB6AC">S/ {{ number_format($stats['ingresos'], 2) }}</p>
        </div>
        <div class="ad-card p-5" style="border-left:4px solid #F59E0B">
            <p class="text-xs uppercase tracking-wide text-gray-500">Pendientes de pago</p>
            <p class="text-3xl font-extrabold mt-1" style="color:#92400E">{{ $stats['pendientes'] }}</p>
        </div>
        <div class="ad-card p-5" style="border-left:4px solid #3B82F6">
            <p class="text-xs uppercase tracking-wide text-gray-500">Citas de hoy</p>
            <p class="text-3xl font-extrabold ad-navy mt-1">{{ $stats['hoy'] }}</p>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="ad-card p-4 text-center"><p class="text-xs uppercase text-gray-500">Médicos</p><p class="text-2xl font-extrabold ad-navy">{{ $stats['medicos'] }}</p></div>
        <div class="ad-card p-4 text-center"><p class="text-xs uppercase text-gray-500">Pacientes</p><p class="text-2xl font-extrabold ad-navy">{{ $stats['pacientes'] }}</p></div>
        <div class="ad-card p-4 text-center"><p class="text-xs uppercase text-gray-500">Sedes activas</p><p class="text-2xl font-extrabold ad-navy">{{ $stats['sedes'] }}</p></div>
    </div>

    {{-- Citas --}}
    <div class="ad-card overflow-hidden">
        <div class="px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3" style="background:#22396b; color:#fff">
            <h3 class="font-bold">Auditoría de citas recientes</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.appointments.all') }}" class="ad-chip {{ request('status') ? '' : 'activo' }}">Todas</a>
                @foreach($estados as $estado)
                    <a href="{{ route('admin.appointments.all', ['status' => $estado]) }}"
                       class="ad-chip {{ request('status') === $estado ? 'activo' : '' }}">{{ $estado }}</a>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="ad-table w-full border-collapse">
                <thead>
                    <tr>
                        <th>Fecha y hora</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Especialidad</th>
                        <th>Sede</th>
                        <th>Monto</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $apt)
                        @php $estilo = $statusStyles[$apt->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151']; @endphp
                        <tr>
                            <td>
                                <span class="font-semibold">{{ \Carbon\Carbon::parse($apt->date)->format('d/m/Y') }}</span>
                                <span class="text-gray-500"> · {{ \Carbon\Carbon::parse($apt->time)->format('h:i A') }}</span>
                            </td>
                            <td class="font-medium">
                                {{ $apt->patient?->name }} {{ $apt->patient?->last_name_paternal }}
                                @if($apt->dependent_id)
                                    <span class="block text-xs text-gray-400">Cita para un familiar</span>
                                @endif
                            </td>
                            <td>{{ $apt->doctor ? $apt->doctor->name . ' ' . $apt->doctor->last_name_paternal : '—' }}</td>
                            <td>{{ $apt->specialty?->name }}</td>
                            <td>{{ $apt->headquarter?->name }}</td>
                            <td>
                                @if($apt->invoice)
                                    S/ {{ number_format($apt->invoice->amount, 2) }}
                                    <span class="block text-xs text-gray-400">{{ $apt->invoice->payment_method }}</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold"
                                      style="background:{{ $estilo['bg'] }}; color:{{ $estilo['text'] }}">{{ $apt->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-gray-500" style="padding:2.5rem">No hay citas para mostrar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($appointments->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $appointments->links() }}</div>
        @endif
    </div>
</div>
@endsection