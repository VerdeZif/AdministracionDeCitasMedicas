# Reglas Críticas de Negocio y Lógica Transaccional

## RN-01: Aislamiento Estricto y Seguridad de Roles
1. Ningún usuario puede invadir módulos ajenos. Middleware estrictos: `CheckAdmin`, `CheckDoctor`, `CheckPatient`.
2. Redirección inmediata al login (HTTP 403) si se intenta acceder a URLs no autorizadas.
3. El registro público (`RegisteredUserController`) fuerza obligatoriamente el rol `patient`. Los doctores solo pueden ser creados por un `admin`.

## RN-02: Flujo y Máquina de Estados de la Cita
El campo `status` de la tabla `appointments` sigue una transición unidireccional:
1. **Pendiente de Pago:** Estado inicial.
2. **Confirmada:** Tras pago exitoso. Solo desde este estado el médico puede interactuar (Atender o Ausente).
3. **En Curso:** El médico inicia la atención en consultorio.
4. **Atendida:** El médico finaliza la cita, requiriéndose ingresar el `diagnosis` (diagnóstico) e `instructions` (indicaciones).
5. **Ausente:** El paciente no llegó.
6. **Cancelada:** Puede ejecutarse si está Pendiente o Confirmada. Requiere un `cancellation_reason`. Si la cita ya estaba Confirmada, activa la bandera `refund_pending` para el área administrativa.

## RN-03: Motor Anti-Colisión (Bloqueos y Citas)
1. **Reservas de Pacientes:** No se puede agendar si la combinación `doctor_id`, `date` y `time` ya existe en estado Confirmada, En Curso, o si coincide con un registro en `doctor_blocks`.
2. **Bloqueos de Médicos (`DoctorBlockController`):** El médico no puede bloquear un rango horario (`start_time` a `end_time`) si dentro de ese rango ya existe una cita confirmada para ese día. El sistema aborta la petición y muestra error.

## RN-04: Gestión de Identidad (Formularios y Backend)
1. Los campos DNI (8 dígitos precisos), Teléfono (9 dígitos) y Nombres (solo letras) deben validarse tanto en frontend (HTML5/JS) como en Backend (Reglas de Request).
2. El perfil base del paciente es inmutable desde el form de reservas. El controlador extrae `patient_id` usando directamente `Auth::id()` para evitar suplantaciones por inyección en el DOM.