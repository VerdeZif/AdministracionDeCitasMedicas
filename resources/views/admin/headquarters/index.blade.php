@extends('layouts.app')

@section('content')
<style>
    .sp-navy { color:#22396b; }
    .sp-card { background:#fff; border:1.5px solid #4DB6AC33; border-radius:1rem; }
    .sp-input { width:100%; border:1px solid #d1d5db; border-radius:.5rem; padding:.55rem .75rem; font-size:.875rem; }
    .sp-input:focus { outline:none; border-color:#4DB6AC; box-shadow:0 0 0 2px #4DB6AC33; }
    .sp-btn { color:#fff; font-weight:700; padding:.6rem 1.25rem; border-radius:.6rem; font-size:.875rem; transition:filter .15s; }
    .sp-btn:hover { filter:brightness(.92); }
    .sp-table th { padding:.9rem 1rem; text-align:left; font-size:.8rem; color:#22396b; background:#f9fafb; border-bottom:1px solid #e5e7eb; }
    .sp-table td { padding:.9rem 1rem; border-bottom:1px solid #f3f4f6; font-size:.875rem; vertical-align:middle; }
</style>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">
    <div class="mb-8 pb-4 border-b border-gray-200">
        <a href="{{ route('admin.appointments.all') }}" class="text-sm underline" style="color:#4DB6AC">← Volver al panel</a>
        <h2 class="text-3xl font-extrabold sp-navy mt-1">Sedes</h2>
        <p class="text-sm text-gray-500">Administra las sedes de la clínica.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#DCFCE7; border:1px solid #BBF7D0; color:#166534">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">{{ $errors->first() }}</div>
    @endif

    <div class="sp-card p-6 mb-8">
        <h3 class="text-lg font-bold sp-navy mb-4">Nueva sede</h3>
        <form method="POST" action="{{ route('admin.sedes.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            @csrf
            <div class="md:col-span-4">
                <label class="block text-xs font-medium mb-1">Nombre</label>
                <input name="name" value="{{ old('name') }}" required class="sp-input" placeholder="Ej. Sede Este">
            </div>
            <div class="md:col-span-6">
                <label class="block text-xs font-medium mb-1">Dirección</label>
                <input name="address" value="{{ old('address') }}" required class="sp-input" placeholder="Av. Principal 123, Lima">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="sp-btn w-full" style="background:#4DB6AC">Agregar</button>
            </div>
        </form>
    </div>

    <div class="sp-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="sp-table w-full border-collapse">
                <thead>
                    <tr><th>Nombre</th><th>Dirección</th><th style="text-align:right">Acciones</th></tr>
                </thead>
                <tbody>
                    @forelse($headquarters as $hq)
                        <tr>
                            <td class="font-semibold">{{ $hq->name }}</td>
                            <td class="text-gray-500">{{ $hq->address }}</td>
                            <td style="text-align:right; white-space:nowrap">
                                <button type="button" class="font-semibold underline mr-3" style="color:#22396b"
                                        data-id="{{ $hq->id }}"
                                        data-name="{{ $hq->name }}"
                                        data-address="{{ $hq->address }}"
                                        onclick="abrirEditar(this)">Editar</button>
                                <form method="POST" action="{{ route('admin.sedes.destroy', $hq) }}" class="inline"
                                      onsubmit="return confirm('¿Eliminar {{ e($hq->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold underline text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-gray-500" style="padding:2.5rem">Aún no hay sedes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalEditar" class="hidden" style="position:fixed; inset:0; z-index:9999; background:rgba(17,24,39,.6); overflow-y:auto;">
    <div style="min-height:100%; display:flex; align-items:center; justify-content:center; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full relative p-6" style="max-width:28rem;">
            <button type="button" onclick="cerrarEditar()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">✖</button>
            <h3 class="text-xl font-bold sp-navy mb-4">Editar sede</h3>
            <form id="formEditar" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium mb-1">Nombre</label>
                    <input id="e_name" name="name" required class="sp-input">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Dirección</label>
                    <input id="e_address" name="address" required class="sp-input">
                </div>
                <button type="submit" class="sp-btn w-full" style="background:#22396b">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

<script>
    const urlBase = @json(url('admin/sedes'));
    function abrirEditar(btn) {
        document.getElementById('formEditar').action = `${urlBase}/${btn.dataset.id}`;
        document.getElementById('e_name').value = btn.dataset.name;
        document.getElementById('e_address').value = btn.dataset.address;
        document.getElementById('modalEditar').classList.remove('hidden');
    }
    function cerrarEditar() {
        document.getElementById('modalEditar').classList.add('hidden');
    }
</script>
@endsection