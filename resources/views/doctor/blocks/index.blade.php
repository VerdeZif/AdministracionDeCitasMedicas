@extends('layouts.app')

@section('content')
<style>
    .sp-navy { color:#22396b; }
    .sp-card { background:#fff; border:1.5px solid #4DB6AC33; border-radius:1rem; }
    .sp-input { width:100%; border:1px solid #d1d5db; border-radius:.5rem; padding:.55rem .75rem; font-size:.875rem; background:#fff; }
    .sp-input:focus { outline:none; border-color:#4DB6AC; box-shadow:0 0 0 2px #4DB6AC33; }
    .sp-btn { color:#fff; font-weight:700; padding:.6rem 1.25rem; border-radius:.6rem; font-size:.875rem; transition:filter .15s; }
    .sp-btn:hover { filter:brightness(.92); }
    .sp-table th { padding:.9rem 1rem; text-align:left; font-size:.8rem; color:#22396b; background:#f9fafb; border-bottom:1px solid #e5e7eb; }
    .sp-table td { padding:.9rem 1rem; border-bottom:1px solid #f3f4f6; font-size:.875rem; vertical-align:middle; }
</style>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
    <div class="mb-8 pb-4 border-b border-gray-200">
        <a href="{{ route('doctor.dashboard') }}" class="text-sm underline" style="color:#4DB6AC">← Volver a mi agenda</a>
        <h2 class="text-3xl font-extrabold sp-navy mt-1">Bloquear horarios</h2>
        <p class="text-sm text-gray-500">Los pacientes no podrán reservar citas en los rangos que bloquees.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#DCFCE7; border:1px solid #BBF7D0; color:#166534">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">{{ $errors->first() }}</div>
    @endif

    {{-- Nuevo bloqueo --}}
    <div class="sp-card p-6 mb-8">
        <h3 class="text-lg font-bold sp-navy mb-4">Nuevo bloqueo</h3>
        <form method="POST" action="{{ route('doctor.bloqueos.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            @csrf
            <div class="md:col-span-3">
                <label class="block text-xs font-medium mb-1">Fecha</label>
                <input type="date" name="date" value="{{ old('date') }}" min="{{ today()->toDateString() }}" required class="sp-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium mb-1">Desde</label>
                <input type="time" name="start_time" value="{{ old('start_time') }}" required class="sp-input">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium mb-1">Hasta</label>
                <input type="time" name="end_time" value="{{ old('end_time') }}" required class="sp-input">
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs font-medium mb-1">Motivo</label>
                <input name="reason" value="{{ old('reason') }}" required maxlength="255" class="sp-input" placeholder="Ej. Reunión, trámite personal">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="sp-btn w-full" style="background:#4DB6AC">Bloquear</button>
            </div>
        </form>
    </div>

    {{-- Listado --}}
    <div class="sp-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="sp-table w-full border-collapse">
                <thead>
                    <tr><th>Fecha</th><th>Horario</th><th>Motivo</th><th>Estado</th><th style="text-align:right">Acciones</th></tr>
                </thead>
                <tbody>
                    @forelse($blocks as $b)
                        @php
                            $fecha  = \Carbon\Carbon::parse($b->date);
                            $pasado = $fecha->lt(today());
                        @endphp
                        <tr style="{{ $pasado ? 'opacity:.55' : '' }}">
                            <td class="font-semibold">{{ $fecha->translatedFormat('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($b->end_time)->format('h:i A') }}</td>
                            <td class="text-gray-500">{{ $b->reason }}</td>
                            <td>
                                @if($pasado)
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-bold" style="background:#F3F4F6; color:#374151">Pasado</span>
                                @elseif($fecha->isToday())
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-bold" style="background:#FEF3C7; color:#92400E">Hoy</span>
                                @else
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-bold" style="background:#E0F2F1; color:#00695C">Programado</span>
                                @endif
                            </td>
                            <td style="text-align:right">
                                <form method="POST" action="{{ route('doctor.bloqueos.destroy', $b) }}" class="inline"
                                      onsubmit="return confirm('¿Eliminar este bloqueo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold underline text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-gray-500" style="padding:2.5rem">No tienes horarios bloqueados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection