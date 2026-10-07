# Reglas Críticas de Negocio y Lógica Transaccional

Este documento establece las normativas inquebrantables del software. Los Controladores (Raquel) y las Vistas (Fernando) deben programarse para cumplir estrictamente estos lineamientos.

## RN-01: Aislamiento Estricto y Seguridad de Sesiones
1. Ningún usuario no autenticado puede acceder a URLs que comiencen con `/admin`, `/doctor` o `/patient`.
2. Si un Paciente intenta acceder a `/admin/dashboard`, el sistema debe interceptarlo, destruir su sesión (opcional por seguridad) y redirigirlo al Login con un código de error HTTP 403 (Forbidden).
3. Las contraseñas deben estar obligatoriamente hasheadas con `Bcrypt` antes de guardarse en la base de datos.

## RN-02: Integridad e Inmutabilidad del Perfil
1. Los campos de identificación primaria (Documento de Identidad, Nombres y Apellidos) se capturan una sola vez durante el registro.
2. En el flujo de agendamiento, estos campos deben inyectarse en el formulario con el atributo HTML `readonly` y/o `disabled`.
3. El controlador `AppointmentController` ignorará cualquier dato de identidad proveniente del formulario de reserva, extrayéndolos directamente de `Auth::user()` para prevenir inyecciones maliciosas.

## RN-03: Motor Anti-Colisión de Agendas
1. El sistema no permite *overbooking* (sobreventa). 
2. Antes de procesar un pago o guardar una cita, el backend debe verificar que no exista un registro en la tabla `appointments` donde coincidan el `doctor_id`, `date` y `time` con estado `Confirmada` o `Pendiente`.
3. Si existe colisión, se aborta la transacción y se retorna un mensaje de error claro a la vista del paciente.

## RN-04: Transacciones Atómicas (El Flujo de Pago)
1. El proceso de cambiar el estado de una cita a `Confirmada` y registrar el pago en la tabla `invoices` es indivisible.
2. Obligatoriamente debe usarse `DB::transaction()` en Laravel. 
3. Si la generación de la boleta falla por un error de base de datos o conexión, el estado de la cita debe aplicar un `rollback` y mantenerse como `Pendiente de Pago`.

## RN-05: Reglas de Estados de Cita
- **Pendiente de Pago:** Estado inicial tras seleccionar horario. Si no se paga, no bloquea el calendario (o se auto-cancela por script tras 15 minutos).
- **Confirmada:** Transacción simulada exitosa. Bloquea el horario públicamente.
- **Atendida / Ausente:** Estados finales gestionados exclusivamente por el Médico o Administrador.