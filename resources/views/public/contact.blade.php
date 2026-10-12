@extends('layouts.app')

@section('title', 'Contacto')

@push('styles')
<style>
    .contacto { display: grid; grid-template-columns: 1fr 1.4fr; gap: 24px; align-items: start; }
    .campo { margin-bottom: 16px; }
    .campo label { display: block; font-weight: 600; color: var(--marino); margin-bottom: 4px; }
    .campo input, .campo textarea { width: 100%; padding: 10px 12px; border: 1px solid var(--marino); border-radius: 8px; font: inherit; }
    .campo input:focus, .campo textarea:focus { outline: 2px solid var(--marino-suave); }
    .campo input:user-invalid, .campo textarea:user-invalid { border-color: #C0392B; }
    @media (max-width: 760px) { .contacto { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<section class="seccion">
    <div class="contenedor">
        <h2 class="titulo-seccion">Contáctanos</h2>
        <p class="subtitulo">Escríbenos y te responderemos a la brevedad.</p>
        <div class="contacto">
            <div class="tarjeta">
                <h3>Sedes</h3>
                @foreach ($headquarters as $headquarter)
                    <p style="margin-top: 12px;"><strong>{{ $headquarter['name'] }}</strong><br>{{ $headquarter['address'] }}</p>
                @endforeach
            </div>
            {{-- Pendiente: conectar al controlador de contacto cuando exista --}}
            <form class="tarjeta" onsubmit="event.preventDefault(); alert('Formulario de prueba: aún no hay backend conectado.');">
                <div class="campo">
                    <label for="name">Nombre completo</label>
                    <input id="name" name="name" type="text" required minlength="3">
                </div>
                <div class="campo">
                    <label for="email">Correo electrónico</label>
                    <input id="email" name="email" type="email" required>
                </div>
                <div class="campo">
                    <label for="phone">Teléfono</label>
                    <input id="phone" name="phone" type="tel" pattern="[0-9]{9}" title="9 dígitos">
                </div>
                <div class="campo">
                    <label for="message">Mensaje</label>
                    <textarea id="message" name="message" rows="5" required minlength="10"></textarea>
                </div>
                <button type="submit" class="btn btn-primario">Enviar mensaje</button>
            </form>
        </div>
    </div>
</section>
@endsection
