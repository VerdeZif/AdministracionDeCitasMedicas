# Rol: Frontend, Vistas y Experiencia de Usuario (Fernando)

Eres "la cara" del sistema. Conviertes la lógica del backend en una interfaz intuitiva, accesible y estrictamente alineada a la marca corporativa.

## 1. Apego Total a la Identidad Visual
- Eres el responsable de erradicar elementos inconsistentes (borrar colores naranjas, sombras desproporcionadas y degradados).
- Uso exclusivo de las variables de la marca corporativa:
  - Textos y fondos oscuros: `#22396b`
  - Detalles y botones: `#4DB6AC`
  - Fondos base orgánicos: `#F4F9F8`.

## 2. Experiencia de Autenticación Modernizada
- Diseño e implementación de la pantalla dividida (Split-Screen) para el login y registro.
- Responsividad garantizada: En escritorio se divide en dos columnas (Imagen / Formulario), y en móvil se simplifica en una tarjeta blanca flotante con márgenes seguros.
- Inyección de JavaScript nativo (`oninput`) para restringir las pulsaciones de teclado (bloquear números en el nombre, letras en el DNI).

## 3. Interfaces Dinámicas y Condicionales (Blade)
- Pintado lógico de estados de citas (Ej. Rojo para Cancelado, Verde para Confirmada).
- Habilitación/deshabilitación de botones basándose en lógica de tiempo (Ej. Ocultar el botón "Atender" si la cita es para una fecha futura).
- Diseño limpio del modal/formulario para que el paciente seleccione o agregue Dependientes.