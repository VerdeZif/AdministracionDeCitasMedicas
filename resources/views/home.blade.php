@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16 space-y-20">

    <div class="relative w-full h-[550px] lg:h-[500px] bg-[#273B69] rounded-[30px] overflow-hidden shadow-2xl">
        <div id="carousel-slides" class="relative w-full h-full">
            
            <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-100 flex items-center justify-center lg:justify-start">
                <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20 lg:hidden" alt="Fondo Médico">
                
                <div class="relative z-10 w-full lg:w-1/2 px-6 sm:px-12 lg:px-20 text-center lg:text-left text-white">
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight mb-4 uppercase leading-tight drop-shadow-md">
                        ESTAMOS PARA CUIDARTE<br>
                        AGENDA TU <span class="text-[#4DB6AC]">CITA</span><br>
                        MÉDICA HOY
                    </h1>
                    <p class="text-lg font-light mb-8 drop-shadow-sm">Atención rápida, segura y sin filas.</p>
                    <a href="{{ route('patient.appointments.create') }}" class="inline-block bg-[#D6EEE8] text-[#273B69] font-bold py-3 sm:py-4 px-8 rounded-full shadow-lg hover:bg-white transition duration-300">
                        Quiero agendar mi cita
                    </a>
                </div>
                <div class="hidden lg:flex w-1/2 h-full items-center justify-center relative z-10">
                    <div class="bg-white overflow-hidden flex items-center justify-center shadow-inner" style="border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; width: 380px; height: 380px;">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=600&auto=format&fit=crop" alt="Doctora" class="object-cover w-full h-full">
                    </div>
                </div>
            </div>

            <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0 pointer-events-none flex items-center justify-center lg:justify-start">
                <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20 lg:hidden" alt="Staff">
                
                <div class="relative z-10 w-full lg:w-1/2 px-6 sm:px-12 lg:px-20 text-center lg:text-left text-white">
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight mb-4 uppercase leading-tight drop-shadow-md">
                        ESPECIALISTAS<br>
                        DE PRIMER <span class="text-[#4DB6AC]">NIVEL</span>
                    </h1>
                    <p class="text-lg font-light mb-8 drop-shadow-sm">Contamos con un staff altamente capacitado.</p>
                    <a href="{{ route('specialists') }}" class="inline-block bg-[#4DB6AC] text-white font-bold py-3 sm:py-4 px-8 rounded-full shadow-lg hover:bg-teal-500 transition duration-300">
                        Conocer al Staff
                    </a>
                </div>
                <div class="hidden lg:flex w-1/2 h-full items-center justify-center relative z-10">
                    <div class="bg-white overflow-hidden flex items-center justify-center shadow-inner" style="border-radius: 60% 40% 30% 70% / 50% 60% 40% 50%; width: 380px; height: 380px;">
                        <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop" alt="Equipo Médico" class="object-cover w-full h-full">
                    </div>
                </div>
            </div>

            <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0 pointer-events-none flex items-center justify-center lg:justify-start">
                <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20 lg:hidden" alt="Especialidades Médicas">
                
                <div class="relative z-10 w-full lg:w-1/2 px-6 sm:px-12 lg:px-20 text-center lg:text-left text-white">
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight mb-4 uppercase leading-tight drop-shadow-md">
                        ATENCIÓN MÉDICA<br>
                        <span class="text-[#4DB6AC]">ESPECIALIZADA</span>
                    </h1>
                    <p class="text-lg font-light mb-8 drop-shadow-sm">Conoce nuestra amplia gama de áreas médicas diseñadas para cuidar de ti y tu familia.</p>
                    <a href="{{ route('services') }}" class="inline-block bg-white text-[#273B69] font-bold py-3 sm:py-4 px-8 rounded-full shadow-lg hover:bg-gray-100 transition duration-300">
                        Ver Especialidades
                    </a>
                </div>
                <div class="hidden lg:flex w-1/2 h-full items-center justify-center relative z-10">
                    <div class="bg-white overflow-hidden flex items-center justify-center shadow-inner" style="border-radius: 50% 50% 40% 60% / 60% 40% 50% 50%; width: 380px; height: 380px;">
                        <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=600&auto=format&fit=crop" alt="Especialidades Médicas" class="object-cover w-full h-full">
                    </div>
                </div>
            </div>
        </div>

        <button onclick="prevSlide()" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white transition z-20">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button onclick="nextSlide()" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white transition z-20">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <div class="flex flex-col lg:flex-row items-center gap-12 pt-8">
        <div class="lg:w-1/2 flex justify-center relative w-full">
            <div class="bg-white absolute inset-0 rounded-[100px] transform -rotate-6 scale-105 -z-10 shadow-sm"></div>
            <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=500&auto=format&fit=crop" alt="Médico sonriendo" class="rounded-[40px] shadow-lg object-cover w-full max-w-[350px] h-[350px] relative z-10">
        </div>
        
        <div class="lg:w-1/2 space-y-6 text-center lg:text-left">
            <div class="flex items-center justify-center lg:justify-start gap-4">
                <svg class="w-10 h-10 text-[#273B69]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h2 class="text-3xl font-bold text-[#4DB6AC]">¿Por qué elegirnos?</h2>
            </div>
            <p class="text-[#273B69] leading-relaxed text-sm font-medium">
                Healthy Life cuenta con años de experiencia brindando salud de calidad a todos nuestros pacientes. Para ello disponemos de un gran equipo de doctores y personal asistencial altamente calificado, comprometidos con el buen servicio, la atención rápida y el cuidado integral de tu bienestar.
            </p>
        </div>
    </div>

    <div class="text-center pt-8">
        <h2 class="text-3xl font-bold text-[#273B69] mb-10">Conócenos</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="text-[#4DB6AC] mb-4"><svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                <h3 class="text-[#273B69] font-bold text-lg">Sedes</h3>
                <p class="text-sm text-gray-500 mt-2 font-medium">Contamos con {{ isset($headquartersCount) ? $headquartersCount : 0 }} sedes</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="text-[#4DB6AC] mb-4"><svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></div>
                <h3 class="text-[#273B69] font-bold text-lg">Citas en Línea</h3>
                <p class="text-sm text-gray-500 mt-2 font-medium">Agendamiento 24/7</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="text-[#4DB6AC] mb-4"><svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                <h3 class="text-[#273B69] font-bold text-lg">Staff Médico</h3>
                <p class="text-sm text-gray-500 mt-2 font-medium">Especialistas certificados</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="text-[#4DB6AC] mb-4"><svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                <h3 class="text-[#273B69] font-bold text-lg">Historial Seguro</h3>
                <p class="text-sm text-gray-500 mt-2 font-medium">Privacidad garantizada</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 mt-16 bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
        
        <div class="w-full lg:w-1/2 relative z-10 text-center lg:text-left">
            <h2 class="text-3xl font-bold text-[#4DB6AC] mb-2">Tu salud es importante para nosotros.</h2>
            <h3 class="text-xl text-gray-500 mb-8">Tenemos experiencia con...</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-2 gap-y-10 gap-x-6 text-left">
                
                <div class="flex flex-col items-center md:items-start lg:items-start border-t-2 md:border-t-0 md:border-l-4 lg:border-t-0 lg:border-l-4 border-[#273B69] pt-4 md:pt-0 md:pl-4 lg:pt-0 lg:pl-4">
                    <div class="text-[#4DB6AC] mb-2"><svg class="w-7 h-7 mx-auto md:mx-0 lg:mx-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                    <p class="font-bold text-[#273B69] text-2xl sm:text-3xl">+{{ isset($doctorsCount) ? $doctorsCount : 0 }}</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Doctores</p>
                </div>
                
                <div class="flex flex-col items-center md:items-start lg:items-start border-t-2 md:border-t-0 md:border-l-4 lg:border-t-0 lg:border-l-4 border-[#273B69] pt-4 md:pt-0 md:pl-4 lg:pt-0 lg:pl-4">
                    <div class="text-[#4DB6AC] mb-2"><svg class="w-7 h-7 mx-auto md:mx-0 lg:mx-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                    <p class="font-bold text-[#273B69] text-2xl sm:text-3xl">{{ isset($headquartersCount) ? $headquartersCount : 0 }}</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Sedes</p>
                </div>
                
                <div class="flex flex-col items-center md:items-start lg:items-start border-t-2 md:border-t-0 md:border-l-4 lg:border-t-0 lg:border-l-4 border-[#4DB6AC] pt-4 md:pt-0 md:pl-4 lg:pt-0 lg:pl-4">
                    <div class="text-[#273B69] mb-2"><svg class="w-7 h-7 mx-auto md:mx-0 lg:mx-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                    <p class="font-bold text-[#273B69] text-2xl sm:text-3xl">+5,000</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Pacientes</p>
                </div>
                
                <div class="flex flex-col items-center md:items-start lg:items-start border-t-2 md:border-t-0 md:border-l-4 lg:border-t-0 lg:border-l-4 border-[#4DB6AC] pt-4 md:pt-0 md:pl-4 lg:pt-0 lg:pl-4">
                    <div class="text-[#273B69] mb-2"><svg class="w-7 h-7 mx-auto md:mx-0 lg:mx-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg></div>
                    <p class="font-bold text-[#273B69] text-2xl sm:text-3xl">+5 años</p>
                    <p class="text-[10px] sm:text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Experiencia</p>
                </div>
            </div>
        </div>
        
        <div class="w-full lg:w-1/2 flex justify-center relative z-10 mt-8 lg:mt-0">
            <div class="bg-white rounded-full overflow-hidden w-[280px] h-[280px] sm:w-[380px] sm:h-[380px] flex items-center justify-center shadow-lg ring-8 ring-gray-50">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=500&auto=format&fit=crop" alt="Equipo Médico" class="object-cover w-full h-full">
            </div>
        </div>
    </div>

</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if(i === index) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('opacity-100');
            } else {
                slide.classList.add('opacity-0', 'pointer-events-none');
                slide.classList.remove('opacity-100');
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    setInterval(nextSlide, 6000);
</script>
@endsection