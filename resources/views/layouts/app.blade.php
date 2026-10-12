<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio') | {{ config('app.name') }}</title>
    <style>
        :root {
            --fondo: #D6EEE8;
            --marino: #0A1F8F;
            --marino-suave: #2A3FA8;
            --blanco: #FFFFFF;
            --texto: #1B2240;
            --gris: #5B6380;
            --esmeralda: #0F9D6E;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: "Segoe UI", system-ui, sans-serif; background: var(--fondo); color: var(--texto); line-height: 1.6; }
        a { color: inherit; text-decoration: none; }
        .contenedor { max-width: 1120px; margin: 0 auto; padding: 0 16px; }

        /* Navbar */
        .navbar { background: var(--marino); color: var(--blanco); position: sticky; top: 0; z-index: 10; }
        .navbar .contenedor { display: flex; align-items: center; justify-content: space-between; height: 64px; gap: 16px; }
        .marca { font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 8px; }
        .marca span { background: var(--fondo); color: var(--marino); border-radius: 8px; padding: 2px 8px; }
        .menu { display: flex; gap: 4px; list-style: none; align-items: center; }
        .menu a { padding: 8px 12px; border-radius: 6px; font-size: .95rem; }
        .menu a:hover, .menu a.activo { background: var(--marino-suave); }
        .btn { display: inline-block; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: 2px solid var(--marino); cursor: pointer; font-size: .95rem; }
        .btn-primario { background: var(--marino); color: var(--blanco); }
        .btn-primario:hover { background: var(--marino-suave); }
        .btn-claro { background: var(--blanco); color: var(--marino); }
        .navbar .menu a.btn-claro { border-color: var(--blanco); padding: 6px 14px; margin-left: 8px; }
        .navbar .menu a.btn-claro:hover { background: var(--fondo); }
        .menu-toggle { display: none; background: none; border: 0; color: var(--blanco); font-size: 1.6rem; cursor: pointer; }

        /* Contenido */
        main { min-height: calc(100vh - 64px - 140px); }
        .seccion { padding: 56px 0; }
        .titulo-seccion { color: var(--marino); font-size: 1.8rem; margin-bottom: 8px; }
        .subtitulo { color: var(--gris); margin-bottom: 32px; }
        .grilla { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .tarjeta { background: var(--blanco); border: 1px solid var(--marino); border-radius: 12px; padding: 24px; }
        .tarjeta h3 { color: var(--marino); margin-bottom: 6px; }
        .precio { color: var(--marino); font-weight: 700; font-size: 1.2rem; margin-top: 12px; }

        /* Footer */
        footer { background: var(--marino); color: var(--blanco); padding: 32px 0; margin-top: 40px; }
        footer .contenedor { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; font-size: .9rem; }
        footer p { opacity: .85; }

        @media (max-width: 760px) {
            .menu-toggle { display: block; }
            .menu { display: none; position: absolute; top: 64px; left: 0; right: 0; background: var(--marino); flex-direction: column; align-items: stretch; padding: 8px 16px 16px; }
            .menu.abierto { display: flex; }
            .navbar .menu a.btn-claro { margin: 8px 0 0; text-align: center; }
            .titulo-seccion { font-size: 1.5rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="contenedor">
            <a href="{{ route('home') }}" class="marca"><span>+</span> Citas Médicas</a>
            <button class="menu-toggle" aria-label="Abrir menú" onclick="document.querySelector('.menu').classList.toggle('abierto')">☰</button>
            <ul class="menu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'activo' : '' }}">Inicio</a></li>
                <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'activo' : '' }}">Especialidades</a></li>
                <li><a href="{{ route('specialists') }}" class="{{ request()->routeIs('specialists') ? 'activo' : '' }}">Médicos</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'activo' : '' }}">Contacto</a></li>
                <li><a href="#" class="btn btn-claro">Iniciar sesión</a></li>
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="contenedor">
            <div>
                <strong>{{ config('app.name') }}</strong>
                <p>Reserva tu cita en línea, rápido y seguro.</p>
            </div>
            <p>&copy; {{ date('Y') }} Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
