# Informe de Auditoría y Certificación de Calidad (QA)

**Líder / Revisor:** Israel Verde
**Propósito:** Matriz de verificación obligatoria antes de desplegar código a producción (`main`).

## Fase 1: Auditoría de Base de Datos y Modelos (Jybran)
| ID | Criterio de Aceptación | Estado | Observaciones |
| :--- | :--- | :--- | :--- |
| DB-1 | El comando `php artisan migrate:fresh --seed` ejecuta sin errores de Foreign Keys. | [ ] | Se resolvieron los errores de orden de migraciones (`specialties` antes de `users`). |
| DB-2 | El diagrama ER actualizado en Mermaid coincide al 100% con los esquemas DDL. | [ ] | |
| DB-3 | Columnas de auditoría médica (`diagnosis`, `cancellation_reason`) son migradas correctamente. | [ ] | |
| DB-4 | Tablas críticas (`users`, `specialties`) soportan SoftDeletes. | [ ] | |

## Fase 2: Auditoría de Backend y Seguridad (Raquel)
| ID | Criterio de Aceptación | Estado | Observaciones |
| :--- | :--- | :--- | :--- |
| BK-1 | Creación de Bloqueo Médico falla si hay una cita en medio. | [ ] | Probado vía `DoctorBlockController`. |
| BK-2 | Citas canceladas post-pago marcan `refund_pending = true`. | [ ] | |
| BK-3 | El controlador `RegisteredUserController` incluye y valida los 10 campos nuevos del paciente. | [ ] | |
| BK-4 | Inyección de roles bloqueada: crear usuario desde web siempre asigna rol `patient`. | [ ] | |

## Fase 3: Auditoría de Frontend y UI/UX (Fernando)
| ID | Criterio de Aceptación | Estado | Observaciones |
| :--- | :--- | :--- | :--- |
| UI-1 | Se eliminaron todos los colores naranjas y degradados. Paleta `#22396b` / `#4DB6AC` respetada. | [ ] | |
| UI-2 | El registro y login es responsive (Split-screen oculto en móviles y envuelto en tarjeta blanca). | [ ] | |
| UI-3 | Los modales y selects de dependencia muestran nombre real del familiar (`full_name`). | [ ] | |
| UI-4 | Restricciones de teclado (No letras en Celular/DNI, no números en Nombre) operativas. | [ ] | |