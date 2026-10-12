@extends('layouts.app')

@section('title', 'Inicio')

@push('styles')
<style>
    .hero { background: var(--marino); color: var(--blanco); padding: 72px 0 96px; }
    .hero .contenedor { display: grid; grid-template-columns: 1.3fr 1fr; gap: 40px; align-items: center; }
    .hero h1 { font-size: 2.4rem; line-height: 1.2; margin-bottom: 16px; }
    .hero p { opacity: .9; margin-bottom: 28px; font-size: 1.05rem; }
    .hero .acciones { display: flex; gap: 12px; flex-wrap: wrap; }
    .hero .btn-claro { border-color: var(--blanco); }
    .hero .btn-borde { background: transparent; color: var(--blanco); border-color: var(--blanco); }
    .hero-panel { background: var(--fondo); color: var(--marino); border-radius: 16px; padding: 28px; }
    .hero-panel h3 { margin-bottom: 12px; }
    .hero-panel ol { padding-left: 20px; }
    .hero-panel li { margin-bottom: 8px; }
    .metricas { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-top: -48px; }
    .metrica { background: var(--blanco); border: 1px solid var(--marino); border-radius: 12px; padding: 20px; text-align: center; }
    .metrica strong { display: block; font-size: 1.9rem; color: var(--marino); }
    .metrica span { color: var(--gris); font-size: .9rem; }
    @media (max-width: 760px) {
        .hero .contenedor { grid-template-columns: 1fr; }
        .hero h1 { font-size: 1.8rem; }
    }
</style>
@endpush

@section('content')
<section class="hero">
    <div class="contenedor">
        <div>
            <h1>Tu cita médica, sin colas ni llamadas</h1>
            <p>Elige la sede, la especialidad y el médico. Reserva tu horario y confirma con un pago en línea en minutos.</p>
            <div class="acciones">
                <a href="#" class="btn btn-claro">Reservar cita</a>
                <a href="{{ route('services') }}" class="btn btn-borde">Ver especialidades</a>
            </div>
        </div>
        <div class="hero-panel">
            <h3>¿Cómo funciona?</h3>
            <ol>
                <li>Crea tu cuenta con tu DNI.</li>
                <li>Elige sede, especialidad y médico.</li>
                <li>Selecciona un horario disponible.</li>
                <li>Paga en línea y recibe tu comprobante.</li>
            </ol>
        </div>
    </div>
</section>

<div class="contenedor">
    <div class="metricas">
        @foreach ($metrics as $metric)
            <div class="metrica">
                <strong>{{ $metric['value'] }}</strong>
                <span>{{ $metric['label'] }}</span>
            </div>
        @endforeach
    </div>
</div>

<section class="seccion">
    <div class="contenedor">
        <h2 class="titulo-seccion">Especialidades destacadas</h2>
        <p class="subtitulo">Atención presencial en nuestras sedes.</p>
        <div class="grilla">
            @foreach ($specialties as $specialty)
                <div class="tarjeta">
                    <h3>{{ $specialty['name'] }}</h3>
                    <p>{{ $specialty['description'] }}</p>
                    <p class="precio">S/ {{ number_format($specialty['price'], 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
