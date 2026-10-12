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

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    <div class="mb-8 pb-4 border-b border-gray-200">
        <a href="{{ route('admin.appointments.all') }}" class="text-sm underline" style="color:#4DB6AC">← Volver al panel</a>
        <h2 class="text-3xl font-extrabold sp-navy mt-1">Médicos</h2>
        <p class="text-sm text-gray-500">Registra y administra al personal médico.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#DCFCE7; border:1px solid #BBF7D0; color:#166534">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-lg p-3 text-sm" style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C">{{ $errors->first() }}</div>
    @endif

    {{-- Crear --}}
    <div class="sp-card p-6 mb-8">
        <h3 class="text-lg font-bold sp-navy mb-4">Nuevo médico</h3>
        <form method="POST" action="{{ route('admin.medicos.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            @csrf
            <div class="md:col-span-2"><label class="block text-xs font-medium mb-1">Nombres</label>
                <input name="name" value="{{ old('name') }}" required class="sp-input"></div>
            <div class="md:col-span-2"><label class="block text-xs font-medium mb-1">Apellido paterno</label>
                <input name="last_name_paternal" value="{{ old('last_name_paternal') }}" required class="sp-input"></div>
            <div class="md:col-span-2"><label class="block text-xs font-medium mb-1">Apellido materno</label>
                <input name="last_name_maternal" value="{{ old('last_name_maternal') }}" required class="sp-input"></div>

            <div><label class="block text-xs font-medium mb-1">DNI</label>
                <input name="dni" value="{{ old('dni') }}" required maxlength="8" inputmode="numeric" class="sp-input"></div>
            <div><label class="block text-xs font-medium mb-1">Nacimiento</label>
                <input name="birth_date" type="date" value="{{ old('birth_date') }}" required class="sp-input"></div>
            <div><label class="block text-xs font-medium mb-1">Sexo</label>
                <select name="gender" required class="sp-input">
                    <option value="M" @selected(old('gender') === 'M')>Masculino</option>
                    <option value="F" @selected(old('gender') === 'F')>Femenino</option>
                </select></div>
            <div><label class="block text-xs font-medium mb-1">Teléfono</label>
                <input name="phone" value="{{ old('phone') }}" class="sp-input"></div>
            <div class="md:col-span-2"><label class="block text-xs font-medium mb-1">Especialidad</label>
                <select name="specialty_id" required class="sp-input">
                    <option value="">-- Seleccione --</option>
                    @foreach($specialties as $sp)
                        <option value="{{ $sp->id }}" @selected(old('specialty_id') == $sp->id)>{{ $sp->name }}</option>
                    @endforeach
                </select></div>

            <div class="md:col-span-2"><label class="block text-xs font-medium mb-1">Correo</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="sp-input"></div>
            <div class="md:col-span-2"><label class="block text-xs font-medium mb-1">Contraseña (mín. 8)</label>
                <input name="password" type="password" required minlength="8" class="sp-input"></div>
            <div class="md:col-span-2 flex items-end">
                <button type="submit" class="sp-btn w-full" style="background:#4DB6AC">Registrar médico</button>
            </div>
        </form>
    </div>

    {{-- Listado --}}
    <div class="sp-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="sp-table w-full border-collapse">
                <thead>
                    <tr><th>Médico</th><th>DNI</th><th>Especialidad</th><th>Contacto</th><th style="text-align:right">Acciones</th></tr>
                </thead>
                <tbody>
                    @forelse($doctors as $d)
                        <tr>
                            <td class="font-semibold">{{ $d->name }} {{ $d->last_name_paternal }} {{ $d->last_name_maternal }}</td>
                            <td>{{ $d->dni }}</td>
                            <td>{{ $d->specialty?->name ?? '—' }}</td>
                            <td class="text-gray-500">{{ $d->email }}<span class="block text-xs">{{ $d->phone }}</span></td>
                            <td style="text-align:right; white-space:nowrap">
                                <button type="button" class="font-semibold underline mr-3" style="color:#22396b"
                                        data-id="{{ $d->id }}"
                                        data-name="{{ $d->name }}"
                                        data-paternal="{{ $d->last_name_paternal }}"
                                        data-maternal="{{ $d->last_name_maternal }}"
                                        data-dni="{{ $d->dni }}"
                                        data-birth="{{ $d->birth_date ? \Carbon\Carbon::parse($d->birth_date)->format('Y-m-d') : '' }}"
                                        data-phone="{{ $d->phone }}"
                                        data-gender="{{ $d->gender }}"
                                        data-email="{{ $d->email }}"
                                        data-specialty="{{ $d->specialty_id }}"
                                        onclick="abrirEditar(this)">Editar</button>
                                <form method="POST" action="{{ route('admin.medicos.destroy', $d->id) }}" class="inline"
                                      onsubmit="return confirm('¿Eliminar a {{ e($d->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold underline text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-gray-500" style="padding:2.5rem">Aún no hay médicos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal editar --}}
<div id="modalEditar" class="hidden" style="position:fixed; inset:0; z-index:9999; background:rgba(17,24,39,.6); overflow-y:auto;">
    <div style="min-height:100%; display:flex; align-items:center; justify-content:center; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full relative p-6" style="max-width:40rem;">
            <button type="button" onclick="cerrarEditar()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">✖</button>
            <h3 class="text-xl font-bold sp-navy mb-4">Editar médico</h3>
            <form id="formEditar" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')
                <div><label class="block text-xs font-medium mb-1">Nombres</label><input id="e_name" name="name" required class="sp-input"></div>
                <div><label class="block text-xs font-medium mb-1">Apellido paterno</label><input id="e_paternal" name="last_name_paternal" required class="sp-input"></div>
                <div><label class="block text-xs font-medium mb-1">Apellido materno</label><input id="e_maternal" name="last_name_maternal" required class="sp-input"></div>
                <div><label class="block text-xs font-medium mb-1">DNI</label><input id="e_dni" name="dni" required maxlength="8" class="sp-input"></div>
                <div><label class="block text-xs font-medium mb-1">Nacimiento</label><input id="e_birth" name="birth_date" type="date" required class="sp-input"></div>
                <div><label class="block text-xs font-medium mb-1">Sexo</label>
                    <select id="e_gender" name="gender" required class="sp-input">
                        <option value="M">Masculino</option><option value="F">Femenino</option>
                    </select></div>
                <div><label class="block text-xs font-medium mb-1">Teléfono</label><input id="e_phone" name="phone" class="sp-input"></div>
                <div><label class="block text-xs font-medium mb-1">Especialidad</label>
                    <select id="e_specialty" name="specialty_id" required class="sp-input">
                        @foreach($specialties as $sp)
                            <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                        @endforeach
                    </select></div>
                <div><label class="block text-xs font-medium mb-1">Correo</label><input id="e_email" name="email" type="email" required class="sp-input"></div>
                <div><label class="block text-xs font-medium mb-1">Nueva contraseña (opcional)</label><input name="password" type="password" minlength="8" class="sp-input" placeholder="Dejar vacío para no cambiar"></div>
                <div class="md:col-span-2"><button type="submit" class="sp-btn w-full" style="background:#22396b">Guardar cambios</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    const urlBase = @json(url('admin/medicos'));
    function abrirEditar(b) {
        const d = b.dataset;
        document.getElementById('formEditar').action = `${urlBase}/${d.id}`;
        document.getElementById('e_name').value = d.name;
        document.getElementById('e_paternal').value = d.paternal;
        document.getElementById('e_maternal').value = d.maternal;
        document.getElementById('e_dni').value = d.dni;
        document.getElementById('e_birth').value = d.birth;
        document.getElementById('e_phone').value = d.phone;
        document.getElementById('e_gender').value = d.gender;
        document.getElementById('e_specialty').value = d.specialty;
        document.getElementById('e_email').value = d.email;
        document.getElementById('modalEditar').classList.remove('hidden');
    }
    function cerrarEditar() {
        document.getElementById('modalEditar').classList.add('hidden');
    }
</script>
@endsection