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

    $proximas   = $appointments->whereIn('status', ['Pendiente de Pago', 'Confirmada', 'En Curso'])->count();
    $atendidas  = $appointments->where('status', 'Atendida')->count();
    $pendientes = $appointments->where('status', 'Pendiente de Pago')->count();
@endphp

<style>
    .hl-navy { color: #22396b; }
    .hl-btn {
        background: #4DB6AC; color: #fff; font-weight: 700;
        padding: 0.75rem 1.5rem; border-radius: 0.75rem;
        display: inline-block; box-shadow: 0 4px 12px rgba(77,182,172,.35);
        transition: background .2s, transform .2s;
    }
    .hl-btn:hover { background: #3a9d93; transform: translateY(-1px); }
    .hl-card { background: #fff; border: 1.5px solid #4DB6AC33; border-radius: 1.25rem; }
    .hl-date { background: #22396b; color: #fff; border-radius: 0.9rem; width: 3.5rem; text-align: center; padding: 0.4rem 0; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-8 pb-4 border-b border-gray-200">
        <div>
            <p class="text-sm text-gray-500">Hola,</p>
            <h2 class="text-3xl font-extrabold hl-navy">{{ Auth::user()->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Este es tu historial médico y tus próximas citas.</p>
        </div>
        <div class="flex items-center gap-5">
            <a href="{{ route('patient.appointments.create') }}" class="hl-btn">+ Agendar Nueva Cita</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-600 underline font-semibold text-sm">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    {{-- Resumen --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="hl-card p-5">
            <p class="text-xs uppercase tracking-wide text-gray-500">Próximas citas</p>
            <p class="text-3xl font-extrabold hl-navy mt-1">{{ $proximas }}</p>
        </div>
        <div class="hl-card p-5">
            <p class="text-xs uppercase tracking-wide text-gray-500">Pendientes de pago</p>
            <p class="text-3xl font-extrabold mt-1" style="color:#92400E">{{ $pendientes }}</p>
        </div>
        <div class="hl-card p-5">
            <p class="text-xs uppercase tracking-wide text-gray-500">Citas atendidas</p>
            <p class="text-3xl font-extrabold mt-1" style="color:#00695C">{{ $atendidas }}</p>
        </div>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#DCFCE7; border:1px solid #BBF7D0; color:#166534">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Listado --}}
    @forelse($appointments as $apt)
        @if($loop->first)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @endif

            @php
                $fecha  = \Carbon\Carbon::parse($apt->date)->locale('es');
                $hora   = \Carbon\Carbon::parse($apt->time)->format('h:i A');
                $estilo = $statusStyles[$apt->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151'];
            @endphp

            <div class="hl-card p-6 shadow-sm flex flex-col">
                <div class="flex items-start gap-4">
                    <div class="hl-date shrink-0">
                        <span class="block text-xl font-extrabold leading-none">{{ $fecha->format('d') }}</span>
                        <span class="block text-[11px] uppercase tracking-wide mt-1">{{ $fecha->translatedFormat('M') }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="inline-block text-xs font-bold px-2 py-1 rounded-full"
                              style="background: {{ $estilo['bg'] }}; color: {{ $estilo['text'] }}">
                            {{ $apt->status }}
                        </span>
                        <h3 class="text-lg font-bold hl-navy mt-2 truncate">{{ $apt->specialty->name }}</h3>
                        <p class="text-sm text-gray-500">
                            @if($apt->doctor)
                                Dr(a). {{ $apt->doctor->name }} {{ $apt->doctor->last_name_paternal }}
                            @else
                                Médico por asignar
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mt-1">🕒 {{ $hora }}</p>
                    </div>
                </div>

                {{-- Aviso de cita cancelada --}}
                @if($apt->status === 'Cancelada')
                    <div class="mt-4 rounded-lg p-3 text-xs" style="background:#FEF2F2; color:#B91C1C">
                        <span class="font-bold">{{ $apt->cancelled_by === 'doctor' ? 'Cancelada por el médico.' : 'Cancelada.' }}</span>
                        @if($apt->cancellation_reason)
                            Motivo: {{ $apt->cancellation_reason }}
                        @endif
                        @if($apt->refund_pending)
                            <span class="block mt-1 font-semibold">Tu pago está pendiente de reembolso.</span>
                        @endif
                    </div>
                @endif

                {{-- Control recomendado --}}
                @if($apt->status === 'Atendida' && $apt->follow_up_date)
                    <p class="mt-4 text-xs" style="color:#00695C">
                        📋 Control recomendado: {{ \Carbon\Carbon::parse($apt->follow_up_date)->format('d/m/Y') }}
                    </p>
                @endif

                @if($apt->status === 'Pendiente de Pago')
                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-between items-center gap-2 text-sm">
                        <form method="POST" action="{{ route('patient.appointments.cancel', $apt) }}"
                              onsubmit="return confirm('¿Cancelar esta reserva? El horario quedará libre.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 underline font-semibold">Cancelar</button>
                        </form>
                        <a href="{{ route('patient.appointments.reserve', $apt) }}" class="hl-btn" style="padding:.5rem 1rem; font-size:.8rem">
                            Pagar ahora
                        </a>
                    </div>
                @else
                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-between items-center text-sm">
                        <a href="{{ route('patient.appointments.show', $apt) }}"
                           class="font-semibold underline hover:no-underline hl-navy">
                            Ver detalle
                        </a>

                        @if(in_array($apt->status, ['Confirmada', 'En Curso', 'Atendida']))
                            <a href="{{ route('patient.appointments.pdf', $apt->id) }}"
                               class="font-semibold underline hover:no-underline" style="color:#4DB6AC">
                                Descargar PDF
                            </a>
                        @endif
                    </div>
                @endif
            </div>

        @if($loop->last)
        </div>
        @endif
    @empty
        <div class="hl-card p-10 text-center">
            <p class="text-4xl mb-3">🩺</p>
            <h3 class="text-xl font-bold hl-navy">Aún no tienes citas</h3>
            <p class="text-sm text-gray-500 mt-1 mb-6">Agenda tu primera cita en pocos pasos.</p>
            <a href="{{ route('patient.appointments.create') }}" class="hl-btn">Agendar mi primera cita</a>
        </div>
    @endforelse
</div>
@endsection