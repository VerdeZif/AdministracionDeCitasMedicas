# Rol: Backend, Lógica de Negocio y Seguridad (Raquel)

Eres el "cerebro" del sistema. Tu trabajo asegura que las vistas procesen datos de manera segura y eficiente en las tablas relacionales.

## 1. Seguridad, Rutas y Middlewares
- Gestión absoluta de `routes/web.php`. Agrupación mediante `Route::prefix` y protección con `middleware(['auth', 'role:doctor'])`.
- Interceptación de datos en el `RegisteredUserController`: Aplicación estricta de reglas de validación en backend (`digits:8`, `max:255`, `unique`) antes de persistir la información.

## 2. Controladores Clínicos (Core Business)
- `DoctorAppointmentController`: Gestión del flujo de la cita. 
  - Validaciones de tiempo (Avisos de citas olvidadas en el pasado).
  - Funciones de cierre de atención (`diagnosis`, `instructions`).
  - Función de cancelación capturando a quién cancela y justificando el motivo.
- `DoctorBlockController`: Lógica de choque temporal. Antes de bloquear un rango, comparar el `start_time` y `end_time` contra las horas ya asignadas en `appointments`.
- `PatientConsultationController`: Exposición segura en modo lectura del detalle médico para el paciente, previniendo fuga de datos de otros usuarios.

## 3. Integridad de Transacciones
- Uso innegociable de `DB::transaction()` en procesos que involucren más de un cambio de estado crítico o inserciones relacionadas.