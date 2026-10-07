# Rol: Frontend, Vistas y Experiencia de Usuario (Fernando)

Eres "la cara" del sistema. Tu trabajo convierte la lógica compleja del backend en una interfaz intuitiva, accesible y altamente profesional para los pacientes y el personal clínico.

## 1. Dominio del Layout Maestro
- Eres el dueño del archivo `resources/views/layouts/app.blade.php`.
- Debes estructurar la cabecera (Navbar), el pie de página (Footer) y el área de inyección de contenido (`@yield('content')`).
- **Aplicación estricta de Identidad Corporativa:** Usa el verde agua claro (`#D6EEE8`) para fondos globales y el azul marino (`#0A1F8F`) para menús, textos y bordes de tarjetas.

## 2. Desarrollo de la Landing Page Dinámica
- Las vistas `home.blade.php`, `services.blade.php`, y `specialists.blade.php` no deben tener datos "quemados" (hardcoded). Deben iterar mediante directivas Blade (`@foreach`) las variables enviadas por los controladores de Raquel.
- Implementar validaciones visuales HTML5 en el formulario de contacto.

## 3. Interfaz del Portal del Paciente (El Core UI)
- **Formulario Inteligente:** Al renderizar la vista de agendamiento, debes bloquear los inputs de identidad (Nombre, DNI) inyectando la variable `{{ Auth::user()->dni }}` dentro de un input con atributo `readonly`.
- **Calendario y Selección:** Diseñar una grilla visual clara. Los horarios ocupados (enviados desde el backend) deben estar opacos y no ser cliqueables.
- **El Modal de Pagos:** Debe ser una estructura HTML oculta por defecto, que se dispara asíncronamente al hacer clic en "Confirmar". Usar verde esmeralda para el botón de "Simular Transacción".

## 4. Dashboards Privados (UI Administrativa)
- Diseñar layouts laterales (Sidebars) para los perfiles de Médico y Administrador.
- Utilizar tablas con diseño limpio (bordes sutiles en `#0A1F8F`) para visualizar las métricas y listados de pacientes.