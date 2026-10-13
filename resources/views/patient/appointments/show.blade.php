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
    $estilo = $statusStyles[$appointment->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151'];
@endphp

<style>
    .sp-navy { color:#22396b; }
    .sp-card { background:#fff; border:1.5px solid #4DB6AC33; border-radius:1rem; }
    .sp-label { font-size:.75rem; text-transform:uppercase; letter-spacing:.04em; color:#6b7280; }
</style>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
    <div class="mb-8 pb-4 border-b border-gray-200">
        <a href="{{ route('patient.dashboard') }}" class="text-sm underline" style="color:#4DB6AC">← Volver a mi panel</a>
        <div class="flex items-center justify-between mt-1">
            <h2 class="text-3xl font-extrabold sp-navy">Detalle de la cita</h2>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold"
                  style="background:{{ $estilo['bg'] }}; color:{{ $estilo['text'] }}">{{ $appointment->status }}</span>
        </div>
    </div>

    {{-- Datos de la cita --}}
    <div class="sp-card p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <p class="sp-label">Fecha</p>
                <p class="font-semibold sp-navy">{{ \Carbon\Carbon::parse($appointment->date)->translatedFormat('l d \d\e F Y') }}</p>
            </div>
            <div>
                <p class="sp-label">Hora</p>
                <p class="font-semibold sp-navy">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</p>
            </div>
            <div>
                <p class="sp-label">Médico</p>
                <p class="font-semibold sp-navy">{{ $appointment->doctor?->name }} {{ $appointment->doctor?->last_name_paternal }}</p>
            </div>
            <div>
                <p class="sp-label">Especialidad</p>
                <p class="font-semibold sp-navy">{{ $appointment->specialty?->name }}</p>
            </div>
            <div class="sm:col-span-2">
                <p class="sp-label">Sede</p>
                <p class="font-semibold sp-navy">{{ $appointment->headquarter?->name }}</p>
                @if($appointment->headquarter?->address)
                    <p class="text-sm text-gray-500">{{ $appointment->headquarter->address }}</p>
                @endif
            </div>
            @if($appointment->dependent_id)
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-400">Cita registrada para un familiar.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Registro de la consulta --}}
    @if($appointment->status === 'Atendida')
        <div class="sp-card overflow-hidden mb-6">
            <div class="px-6 py-4" style="background:#22396b; color:#fff">
                <h3 class="font-bold">Registro de la consulta</h3>
                @if($appointment->attended_at)
                    <p class="text-xs opacity-80">Atendida el {{ \Carbon\Carbon::parse($appointment->attended_at)->format('d/m/Y h:i A') }}</p>
                @endif
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <p class="sp-label">Diagnóstico</p>
                    <p class="text-gray-700">{!! nl2br(e($appointment->diagnosis)) !!}</p>
                </div>
                <div>
                    <p class="sp-label">Indicaciones / tratamiento</p>
                    <p class="text-gray-700">{!! nl2br(e($appointment->instructions)) !!}</p>
                </div>
                @if($appointment->follow_up_date)
                    <div class="rounded-lg p-3 text-sm" style="background:#E0F2F1; color:#00695C">
                        Tu médico recomienda un control el
                        <strong>{{ \Carbon\Carbon::parse($appointment->follow_up_date)->translatedFormat('d \d\e F Y') }}</strong>.
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Cancelación --}}
    @if($appointment->status === 'Cancelada')
        <div class="mb-6 rounded-lg p-4 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">
            <p class="font-bold mb-1">
                {{ $appointment->cancelled_by === 'doctor' ? 'Esta cita fue cancelada por el médico.' : 'Esta cita fue cancelada.' }}
            </p>
            @if($appointment->cancellation_reason)
                <p>Motivo: {{ $appointment->cancellation_reason }}</p>
            @endif
            @if($appointment->refund_pending)
                <p class="mt-2">Tu pago está pendiente de reembolso. La clínica gestionará la devolución.</p>
            @endif
        </div>
    @endif
</div>
@endsection