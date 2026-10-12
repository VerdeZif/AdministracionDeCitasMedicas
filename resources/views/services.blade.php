@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-[#273B69] mb-4">Nuestras Especialidades Médicas</h2>
        <div class="w-16 h-1 bg-[#4DB6AC] mx-auto mb-6"></div>
        <p class="text-[#273B69] font-medium max-w-2xl mx-auto text-lg">Conoce las áreas de atención en las que nuestros médicos están listos para cuidar de ti y tu familia.</p>
    </div>

    <!-- LÓGICA INTELIGENTE DE IMÁGENES -->
    <?php 
    function getSpecialtyImage($name) {
        // Convertimos a minúsculas y quitamos tildes básicas para facilitar la búsqueda
        $name = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $name));
        
        if (strpos($name, 'cardio') !== false) {
            // Cardiología: Estetoscopio sobre corazón / presión arterial
            return 'https://images.unsplash.com/photo-1505592225030-dad7a0531844?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'pediatr') !== false || strpos($name, 'nino') !== false) {
            // Pediatría: Doctora revisando a un niño/bebé
            return 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'odont') !== false || strpos($name, 'dent') !== false) {
            // Odontología: Consultorio dental
            return 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'derma') !== false) {
            // Dermatología: Cuidado de la piel
            return 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'ginec') !== false || strpos($name, 'obstet') !== false || strpos($name, 'mater') !== false) {
            // Ginecología / Obstetricia: Mujer embarazada en consulta (Cero ecografías)
            return 'https://images.unsplash.com/photo-1531983412531-1f49a365ffed?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'oftalm') !== false || strpos($name, 'ojos') !== false) {
            // Oftalmología: Revisión de la vista
            return 'https://images.unsplash.com/photo-1516714435131-44d6b64dc6a2?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'trauma') !== false || strpos($name, 'ortoped') !== false || strpos($name, 'fisio') !== false) {
            // Traumatología / Terapia: Fisioterapia clínica (Cero radiografías de huesos)
            return 'https://images.unsplash.com/photo-1584467735815-f778f274e296?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'nutrici') !== false) {
            // Nutrición: Dieta balanceada / clínica
            return 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=600&auto=format&fit=crop';
        } elseif (strpos($name, 'psico') !== false || strpos($name, 'psiquia') !== false) {
            // Psicología: Consulta de terapia conversacional
            return 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=600&auto=format&fit=crop';
        }
        
        // IMÁGENES GENÉRICAS DE CONSULTA MÉDICA SI NO COINCIDE CON NINGUNA ARRIBA
        $generics = [
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=600&auto=format&fit=crop', // Estetoscopio clásico
            'https://images.unsplash.com/photo-1551076805-e1869033e561?q=80&w=600&auto=format&fit=crop', // Doctor escuchando al paciente
            'https://images.unsplash.com/photo-1631815587646-b85a1bb027e1?q=80&w=600&auto=format&fit=crop'  // Doctora anotando
        ];
        return $generics[strlen($name) % count($generics)];
    }
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if(isset($specialties) && count($specialties) > 0): ?>
            <?php foreach($specialties as $specialty): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    
                    <div class="h-56 w-full bg-gray-200 relative overflow-hidden">
                        <?php if(isset($specialty->image_path) && $specialty->image_path): ?>
                            <!-- Si el admin subió una foto manual, usamos esa -->
                            <img src="{{ Storage::url($specialty->image_path) }}" alt="{{ $specialty->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <?php else: ?>
                            <!-- Si no, usamos nuestra función inteligente -->
                            <img src="{{ getSpecialtyImage($specialty->name) }}" alt="{{ $specialty->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90">
                        <?php endif; ?>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-[#273B69] via-[#273B69]/40 to-transparent"></div>
                        
                        <h3 class="absolute bottom-5 left-6 right-6 text-white font-extrabold text-xl drop-shadow-md">
                            {{ $specialty->name }}
                        </h3>
                    </div>

                    <div class="p-6 flex flex-col flex-grow border-t-4 border-[#D6EEE8]">
                        <p class="text-sm text-[#273B69] mb-8 line-clamp-3 flex-grow leading-relaxed font-medium opacity-80">
                            {{ $specialty->description ?? 'Atención médica especializada con profesionales altamente capacitados y tecnología de vanguardia para asegurar un diagnóstico preciso y un tratamiento oportuno.' }}
                        </p>
                        
                        <a href="{{ route('patient.appointments.create', ['specialty' => $specialty->id]) }}" class="mt-auto w-full text-center bg-[#D6EEE8] text-[#273B69] font-bold py-3 rounded-lg hover:bg-[#273B69] hover:text-white transition-colors shadow-sm border border-[#273B69]">
                            Agendar Cita
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16 bg-white rounded-3xl border-2 border-dashed border-[#273B69]/30">
                <svg class="mx-auto h-16 w-16 text-[#4DB6AC] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-xl font-bold text-[#273B69]">Aún no hay especialidades</p>
                <p class="text-sm mt-2 text-[#273B69] opacity-70">Por favor, comunícate con el administrador del sistema para registrarlas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
@endsection