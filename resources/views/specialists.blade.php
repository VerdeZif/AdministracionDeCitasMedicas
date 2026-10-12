@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-[#0A1F8F] mb-4">Nuestro Staff Médico</h2>
        <div class="w-16 h-1 bg-[#4DB6AC] mx-auto mb-6"></div>
        <p class="text-[#0A1F8F] font-medium max-w-2xl mx-auto text-lg opacity-80">
            Profesionales altamente capacitados comprometidos con brindarte la mejor atención de salud.
        </p>
    </div>

    <?php 
    // Función para limpiar el nombre y evitar redundancias
    function cleanDoctorName($name) {
        return str_replace(['Dr. ', 'Dra. ', 'Dr ', 'Dra '], '', $name);
    }
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php if(isset($doctors) && count($doctors) > 0): ?>
            <?php foreach($doctors as $index => $doctor): ?>
                
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                    
                    <!-- CONTENEDOR CON ALTURA FIJA (h-72) PARA GARANTIZAR TAMAÑO UNIFORME -->
                    <div class="h-72 w-full bg-[#D6EEE8] overflow-hidden relative">
                        
                        <?php if(isset($doctor->profile_photo_path) && $doctor->profile_photo_path): ?>
                            <!-- Foto subida por el admin -->
                            <img src="{{ Storage::url($doctor->profile_photo_path) }}" alt="Dr. {{ $doctor->name }}" class="object-cover object-top w-full h-full transition-transform duration-700 group-hover:scale-105">
                        <?php else: ?>
                            <!-- Rotación de tus imágenes locales (doc-1.jpg, doc-2.jpg, etc.) -->
                            <?php $localImgIndex = ($index % 6) + 1; ?>
                            <img src="{{ asset('img/doc-' . $localImgIndex . '.jpg') }}" alt="Dr. {{ $doctor->name }}" class="object-cover object-top w-full h-full transition-transform duration-700 group-hover:scale-105">
                        <?php endif; ?>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A1F8F]/30 to-transparent pointer-events-none"></div>
                    </div>

                    <!-- Datos del Médico -->
                    <div class="p-6 flex flex-col flex-grow text-center relative bg-white">
                        
                        <div class="absolute -top-7 left-1/2 transform -translate-x-1/2 bg-[#0A1F8F] rounded-full p-2 border-4 border-white shadow-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        
                        <h4 class="font-extrabold text-lg text-[#0A1F8F] mt-4 truncate" title="{{ $doctor->name }}">
                            Dr(a). {{ cleanDoctorName($doctor->name) }}
                        </h4>
                        
                        <p class="text-xs font-bold text-[#4DB6AC] uppercase tracking-wider mt-1 mb-6">
                            Médico Especialista
                        </p>
                        
                        <!-- Botón -->
                        <a href="{{ route('patient.appointments.create', ['doctor' => $doctor->id]) }}" class="mt-auto w-full inline-block bg-[#D6EEE8] text-[#0A1F8F] font-bold py-2.5 rounded-lg border border-[#0A1F8F] hover:bg-[#0A1F8F] hover:text-white transition-colors text-sm">
                            Reservar Cita
                        </a>
                    </div>
                    
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16 bg-white rounded-3xl border-2 border-dashed border-[#0A1F8F]/30">
                <svg class="mx-auto h-16 w-16 text-[#4DB6AC] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <p class="text-xl font-bold text-[#0A1F8F]">Aún no hay médicos</p>
                <p class="text-sm mt-2 text-[#0A1F8F] opacity-70">El administrador debe registrar al equipo médico en el sistema.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
@endsection