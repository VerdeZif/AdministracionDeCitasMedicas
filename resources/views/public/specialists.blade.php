@extends('layouts.app')

@section('title', 'Médicos')

@push('styles')
<style>
    .avatar { width: 56px; height: 56px; border-radius: 50%; background: var(--fondo); color: var(--marino); display: grid; place-items: center; font-weight: 700; font-size: 1.2rem; margin-bottom: 12px; border: 2px solid var(--marino); }
    .etiqueta { display: inline-block; background: var(--fondo); color: var(--marino); border-radius: 999px; padding: 2px 10px; font-size: .85rem; margin-top: 4px; }
    .sede { color: var(--gris); margin-top: 8px; }
</style>
@endpush

@section('content')
<section class="seccion">
    <div class="contenedor">
        <h2 class="titulo-seccion">Nuestros médicos</h2>
        <p class="subtitulo">Especialistas disponibles para reservar en línea.</p>
        <div class="grilla">
            @foreach ($doctors as $doctor)
                <div class="tarjeta">
                    <div class="avatar">{{ $doctor['initials'] }}</div>
                    <h3>{{ $doctor['name'] }}</h3>
                    <span class="etiqueta">{{ $doctor['specialty'] }}</span>
                    <p class="sede">{{ $doctor['headquarter'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
