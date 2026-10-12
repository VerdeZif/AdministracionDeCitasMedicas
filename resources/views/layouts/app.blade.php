<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Live</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Inyectamos la paleta de colores directamente en Tailwind
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-light': '#D6EEE8', // Verde agua claro (Fondo)
                        'brand-dark': '#0A1F8F',  // Azul marino oscuro (Textos)
                        'brand-action': '#10B981', // Verde esmeralda
                        'brand-action-hover': '#059669', // Verde esmeralda oscuro
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-light font-sans text-brand-dark">

    <!-- Navegación Pública -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-brand-dark flex items-center gap-2">
                        <!-- Icono o Logo aquí si lo deseas -->
                        🏥 Healthy Live
                    </a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <!-- LAS 4 PESTAÑAS EXACTAS -->
                    <a href="{{ route('home') }}" class="text-brand-dark hover:text-brand-action px-3 py-2 rounded-md font-medium transition-colors">Inicio</a>
                    <a href="{{ route('services') }}" class="text-brand-dark hover:text-brand-action px-3 py-2 rounded-md font-medium transition-colors">Servicios</a>
                    <a href="{{ route('specialists') }}" class="text-brand-dark hover:text-brand-action px-3 py-2 rounded-md font-medium transition-colors">Especialistas</a>
                    <a href="{{ route('contact') }}" class="text-brand-dark hover:text-brand-action px-3 py-2 rounded-md font-medium transition-colors">Contáctenos</a>
                    
                    @auth
                        <!-- Si el usuario ya inició sesión -->
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 bg-brand-action text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-brand-action-hover hover:shadow-lg transition-all font-semibold">
                            <!-- Ícono de Usuario -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Ir a mi Panel
                        </a>
                    @else
                        <!-- Si no ha iniciado sesión -->
                        <a href="{{ route('login') }}" class="text-brand-dark hover:text-brand-action px-3 py-2 font-medium transition-colors">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="bg-brand-action text-white px-4 py-2 rounded-md hover:bg-brand-action-hover transition-colors font-medium">Registrarse</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <main>
        @yield('content')
    </main>

</body>
</html>