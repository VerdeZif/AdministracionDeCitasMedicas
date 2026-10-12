<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Healthy Life Medical Clinic</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-[#273B69] bg-[#F4F9F8] flex flex-col min-h-screen relative z-0">
    
    <!-- FONDO GLOBAL DECORATIVO -->
    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
        <svg class="absolute -top-[10%] -right-[5%] w-[70vw] max-w-[800px] text-[#E0F2FE] opacity-60 transform rotate-12" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M45.7,-76.4C58.9,-69.3,69.1,-55.3,77.5,-40.8C85.9,-26.3,92.5,-11.3,91.3,3C90.1,17.3,81.1,30.9,71,43.2C60.9,55.5,49.6,66.4,36.2,74.1C22.8,81.8,7.3,86.3,-7.4,87.6C-22.1,88.9,-36,87,-48.6,80.1C-61.2,73.2,-72.5,61.3,-80.6,47.2C-88.7,33.1,-93.6,16.5,-92.4,1C-91.2,-14.5,-83.9,-29,-74,-40.8C-64.1,-52.6,-51.6,-61.7,-38.3,-68.8C-25,-75.9,-12.5,-81.1,2.3,-84.3C17.1,-87.5,32.5,-83.5,45.7,-76.4Z" transform="translate(100 100)" />
        </svg>
        <svg class="absolute -bottom-[15%] -left-[10%] w-[80vw] max-w-[900px] text-[#D6EEE8] opacity-80 transform -rotate-12" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M48.4,-73.6C62.4,-66.2,73,-52.1,81.4,-36.4C89.8,-20.7,96,-3.4,92.5,12C89,27.4,75.8,40.9,62.2,52C48.6,63.1,34.6,71.8,18.7,78.2C2.8,84.6,-15,88.7,-30.9,84.6C-46.8,80.5,-60.8,68.2,-71.3,53.8C-81.8,39.4,-88.8,22.9,-88.2,7C-87.6,-8.9,-79.4,-24.2,-68.8,-37.2C-58.2,-50.2,-45.2,-60.9,-31.2,-68.4C-17.2,-75.9,-2.2,-80.2,13,-77.9C28.2,-75.6,43.4,-66.7,48.4,-73.6Z" transform="translate(100 100)" />
        </svg>
        <div class="absolute top-[15%] left-[5%] w-72 h-72 opacity-20" style="background-image: radial-gradient(#273B69 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>
        <div class="absolute bottom-[20%] right-[5%] w-72 h-72 opacity-20" style="background-image: radial-gradient(#273B69 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>
        <div class="absolute top-[40%] left-0 w-full h-[150px] opacity-[0.15]" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'150\'><path d=\'M0,75 L300,75 L315,55 L325,110 L345,20 L360,90 L370,75 L800,75\' stroke=\'%230A1F8F\' stroke-width=\'3\' fill=\'none\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/></svg>'); background-repeat: repeat-x; background-position: center;"></div>
    </div>

    <!-- BARRA DE NAVEGACIÓN -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <!-- Logo Principal (Header) -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="Healthy Life" class="h-16 md:h-20 object-contain py-2">
                    </a>
                </div>

                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-[#273B69] hover:text-[#4DB6AC] font-bold px-3 py-2 transition-colors">Inicio</a>
                    <a href="{{ route('services') }}" class="text-[#273B69] hover:text-[#4DB6AC] font-bold px-3 py-2 transition-colors">Servicios</a>
                    <a href="{{ route('specialists') }}" class="text-[#273B69] hover:text-[#4DB6AC] font-bold px-3 py-2 transition-colors">Especialistas</a>
                    <a href="{{ route('contact') }}" class="text-[#273B69] hover:text-[#4DB6AC] font-bold px-3 py-2 transition-colors">Contactanos</a>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-[#273B69] hover:bg-blue-800 text-white font-bold px-5 py-2.5 rounded-full transition-colors text-sm shadow-md">
                            Mi Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#273B69] font-bold hover:text-[#4DB6AC] transition-colors">
                            Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="bg-[#4DB6AC] hover:bg-teal-500 text-white font-bold px-5 py-2.5 rounded-full transition-colors text-sm shadow-md">
                            Crear Cuenta
                        </a>
                    @endauth
                </div>

                <div class="flex items-center md:hidden">
                    <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-[#273B69] hover:text-[#4DB6AC] focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-bold text-[#273B69] hover:bg-[#F4F9F8] rounded-md">Inicio</a>
                <a href="{{ route('services') }}" class="block px-3 py-2 text-base font-bold text-[#273B69] hover:bg-[#F4F9F8] rounded-md">Especialidades</a>
                <a href="{{ route('specialists') }}" class="block px-3 py-2 text-base font-bold text-[#273B69] hover:bg-[#F4F9F8] rounded-md">Staff Médico</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-bold text-[#273B69] hover:bg-[#F4F9F8] rounded-md">Sedes y Contacto</a>
                <div class="border-t border-gray-200 pt-4 pb-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-base font-bold text-[#4DB6AC]">Mi Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-bold text-[#273B69]">Ingresar</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-bold text-[#4DB6AC]">Crear Cuenta</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow relative z-10">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#273B69] text-white pt-16 pb-8 border-t-4 border-[#4DB6AC] relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                
                <div class="flex flex-col items-start">
                    <!-- LOGO SECUNDARIO (SIN FONDO BLANCO). Asegúrate de que logo2.png sea transparente -->
                    <img src="{{ asset('img/logo2.png') }}" alt="Healthy Life Medical Clinic" class="h-16 md:h-20 object-contain mb-6">
                    
                    <p class="text-xs text-[#D6EEE8] uppercase tracking-widest mb-6 font-bold">Te cuida</p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-full transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-full transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                    </div>
                </div>

                <div class="text-sm">
                    <h4 class="font-bold mb-4 uppercase text-[#D6EEE8]">Central de Citas</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li>contacto@healthylife.com</li>
                        <li>(01) 921 254 616</li>
                        <li>Lunes a Sábado: 08:00 am - 06:00 pm</li>
                    </ul>
                </div>

                <div class="text-sm">
                    <h4 class="font-bold mb-4 uppercase text-[#D6EEE8]">Accesos Rápidos</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="{{ route('services') }}" class="hover:text-white transition">Especialidades</a></li>
                        <li><a href="{{ route('specialists') }}" class="hover:text-white transition">Nuestro Staff Médico</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">Sedes y Contacto</a></li>
                    </ul>
                </div>

                <div class="text-sm">
                    <h4 class="font-bold mb-4 uppercase text-[#D6EEE8]">Descarga Nuestra App</h4>
                    <div class="space-y-3">
                        <a href="#" class="block bg-black text-white px-4 py-2 rounded-lg border border-gray-600 hover:border-white transition flex items-center gap-3 w-40">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.523 15.341c-.027-2.673 2.18-3.957 2.279-4.019-1.246-1.821-3.184-2.069-3.886-2.148-1.651-.168-3.226.973-4.068.973-.841 0-2.133-1.001-3.483-.973-1.745.027-3.356.973-4.256 2.535-1.821 3.161-.466 7.828 1.309 10.395.869 1.258 1.888 2.672 3.239 2.621 1.306-.054 1.799-.844 3.376-.844 1.577 0 2.033.844 3.396.817 1.393-.027 2.278-1.282 3.136-2.536 1.002-1.464 1.417-2.886 1.442-2.959-.028-.016-2.775-1.066-2.802-4.148l.318.285zm-2.42-7.145c.683-.827 1.144-1.979 1.018-3.132-1.011.042-2.228.674-2.937 1.503-.637.742-1.189 1.916-1.037 3.048 1.135.088 2.274-.593 2.956-1.419z"/></svg>
                            <div class="text-left">
                                <span class="text-[10px] block leading-none">Descárgalo en el</span>
                                <span class="text-sm font-bold leading-none">App Store</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center text-xs text-[#D6EEE8] border-t border-white/20 pt-6">
                Copyright © {{ date('Y') }} - Healthy Life Medical Clinic. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>