# Manual de Ingeniería, Estandarización y Flujo de Trabajo

## 1. Reglas de Interfaz Gráfica (UI/UX) - (Para Fernando)
La identidad visual clínica es estricta. Las variables CSS o clases utilitarias (Tailwind) deben respetar:
- **Color Base (Fondos/Paneles):** Verde agua claro `#D6EEE8`. Transmite higiene y calma.
- **Color de Contraste (Textos/Íconos/Bordes):** Azul marino oscuro `#0A1F8F`. Garantiza accesibilidad visual y seriedad corporativa.
- **Color de Acento (CTAs):** Verde Esmeralda (ej. `#10B981`). Exclusivo para botones de "Agendar", "Procesar Pago" o "Guardar Cambios".
- **Comportamiento de Modales:** El simulador de pasarela de pagos no debe redirigir a otra URL. Debe abrirse como una capa superpuesta (`z-index` alto) con fondo translúcido, manteniendo el contexto de la reserva.

## 2. Nomenclatura Estricta del Código (Para el Equipo)
- **Base de Datos (Jybran):** Tablas en inglés, minúsculas y plural (`users`, `appointments`, `specialties`, `invoices`). Las llaves foráneas siguen el formato `singular_id` (`doctor_id`, `specialty_id`).
- **Modelos (Jybran/Raquel):** PascalCase singular (`User`, `Appointment`).
- **Controladores (Raquel):** PascalCase con sufijo (`AppointmentController`). Los métodos internos usan camelCase (`processPayment`, `showDashboard`).
- **Rutas (Raquel):** URLs públicas y privadas en inglés y kebab-case (`/book-appointment`, `/doctor/daily-schedule`).
- **Vistas (Fernando):** Archivos kebab-case con extensión de Laravel (`payment-modal.blade.php`, `doctor-dashboard.blade.php`).

## 3. Patrones de Diseño Arquitectónico (Para Raquel)
- **Inyección de Dependencias y Contratos (Interfaces):** Está prohibido colocar lógica de pagos dentro del `AppointmentController`. Se debe crear un contrato en `app/Interfaces/PaymentGatewayInterface.php` y una clase `app/Services/MockPaymentService.php` que la implemente. El controlador solo debe invocar la interfaz, permitiendo escalar a APIs reales en el futuro sin refactorizar el código base.

## 4. Estrategia de Ramas en Git (Git Flow Básico)
- `main`: Rama de producción. Código 100% estable. Solo Israel aprueba *merges* hacia aquí.
- `develop`: Rama de integración. Aquí se unen los trabajos de Raquel, Fernando y Jybran.
- Ramas de características (Features): Cada desarrollador crea ramas desde `develop` con el prefijo de su rol. Ejemplos: `feat/jybran-modelos-bd`, `feat/fernando-vista-pagos`, `feat/raquel-logica-reservas`.