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

    <div class="flex justify-between items-end mb-8 pb-4 border-b border-gray-200">
        <div>
            <a href="{{ route('admin.appointments.all') }}" class="text-sm underline" style="color:#4DB6AC">← Volver al panel</a>
            <h2 class="text-3xl font-extrabold sp-navy mt-1">Especialidades</h2>
            <p class="text-sm text-gray-500">Administra las especialidades y sus precios.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#DCFCE7; border:1px solid #BBF7D0; color:#166534">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">{{ $errors->first() }}</div>
    @endif

    {{-- Crear --}}
    <div class="sp-card p-6 mb-8">
        <h3 class="text-lg font-bold sp-navy mb-4">Nueva especialidad</h3>
        <form method="POST" action="{{ route('admin.especialidades.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            @csrf
            <div class="md:col-span-3">
                <label class="block text-xs font-medium mb-1">Nombre</label>
                <input name="name" value="{{ old('name') }}" required class="sp-input" placeholder="Ej. Neurología">
            </div>
            <div class="md:col-span-5">
                <label class="block text-xs font-medium mb-1">Descripción</label>
                <input name="description" value="{{ old('description') }}" class="sp-input" placeholder="Opcional">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium mb-1">Precio (S/)</label>
                <input name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required class="sp-input" placeholder="0.00">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="sp-btn w-full" style="background:#4DB6AC">Agregar</button>
            </div>
        </form>
    </div>

    {{-- Listado --}}
    <div class="sp-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="sp-table w-full border-collapse">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th style="text-align:right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($specialties as $sp)
                        <tr>
                            <td class="font-semibold">{{ $sp->name }}</td>
                            <td class="text-gray-500">{{ $sp->description ?: '—' }}</td>
                            <td class="font-semibold">S/ {{ number_format($sp->price, 2) }}</td>
                            <td style="text-align:right; white-space:nowrap">
                                <button type="button" class="font-semibold underline mr-3" style="color:#22396b"
                                    data-id="{{ $sp->id }}"
                                    data-name="{{ $sp->name }}"
                                    data-description="{{ $sp->description }}"
                                    data-price="{{ $sp->price }}"
                                    onclick="abrirEditar(this)">Editar</button>
                                <form method="POST" action="{{ route('admin.especialidades.destroy', $sp) }}" class="inline"
                                      onsubmit="return confirm('¿Eliminar {{ e($sp->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold underline text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-gray-500" style="padding:2.5rem">Aún no hay especialidades.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal editar --}}
<div id="modalEditar" class="hidden" style="position:fixed; inset:0; z-index:9999; background:rgba(17,24,39,.6); overflow-y:auto;">
    <div style="min-height:100%; display:flex; align-items:center; justify-content:center; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full relative p-6" style="max-width:28rem;">
            <button type="button" onclick="cerrarEditar()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">✖</button>
            <h3 class="text-xl font-bold sp-navy mb-4">Editar especialidad</h3>
            <form id="formEditar" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium mb-1">Nombre</label>
                    <input id="e_name" name="name" required class="sp-input">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Descripción</label>
                    <input id="e_description" name="description" class="sp-input">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Precio (S/)</label>
                    <input id="e_price" name="price" type="number" step="0.01" min="0" required class="sp-input">
                </div>
                <button type="submit" class="sp-btn w-full" style="background:#22396b">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>

<script>
    const urlBase = @json(url('admin/especialidades'));
    function abrirEditar(btn) {
        document.getElementById('formEditar').action = `${urlBase}/${btn.dataset.id}`;
        document.getElementById('e_name').value = btn.dataset.name;
        document.getElementById('e_description').value = btn.dataset.description;
        document.getElementById('e_price').value = btn.dataset.price;
        document.getElementById('modalEditar').classList.remove('hidden');
    }
    function cerrarEditar() {
        document.getElementById('modalEditar').classList.add('hidden');
    }
</script>
@endsection