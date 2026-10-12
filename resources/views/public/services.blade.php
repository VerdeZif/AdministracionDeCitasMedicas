@extends('layouts.app')

@section('title', 'Especialidades')

@section('content')
<section class="seccion">
    <div class="contenedor">
        <h2 class="titulo-seccion">Especialidades</h2>
        <p class="subtitulo">Consulta los servicios disponibles y su tarifa por consulta.</p>
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
