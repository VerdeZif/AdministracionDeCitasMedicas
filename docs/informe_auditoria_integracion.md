# Informe de Auditoría y Certificación de Calidad (QA)

**Líder / Revisor:** Israel Verde
**Propósito:** Este documento sirve como checklist oficial antes de autorizar la fusión de una rama de desarrollo (`develop`) hacia la rama de producción (`main`). Ningún despliegue procede si falla algún ítem de esta matriz.

## Fase 1: Auditoría de Base de Datos y Modelos (Jybran)
| ID | Criterio de Aceptación | Estado | Observaciones |
| :--- | :--- | :--- | :--- |
| DB-1 | El comando `php artisan migrate:fresh` se ejecuta sin arrojar excepciones. | [ ] | |
| DB-2 | El comando `php artisan db:seed` genera perfiles de prueba completos y funcionales. | [ ] | |
| DB-3 | Las relaciones de Eloquent evitan el problema N+1 al cargar `Appointment::with('doctor')`. | [ ] | |
| DB-4 | Las tablas críticas (`users`, `appointments`) cuentan con SoftDeletes configurados. | [ ] | |

## Fase 2: Auditoría de Backend y Seguridad (Raquel)
| ID | Criterio de Aceptación | Estado | Observaciones |
| :--- | :--- | :--- | :--- |
| BK-1 | Intento de acceso a `/admin` con cuenta de `paciente` redirige con error 403. | [ ] | |
| BK-2 | Simulación de reserva en horario ocupado arroja error de validación (Anti-colisión). | [ ] | |
| BK-3 | Modificación de DNI a través del inspector de elementos es ignorada por el backend. | [ ] | |
| BK-4 | Patrón de Interfaces implementado correctamente para el simulador de pagos. | [ ] | |

## Fase 3: Auditoría de Frontend y UI/UX (Fernando)
| ID | Criterio de Aceptación | Estado | Observaciones |
| :--- | :--- | :--- | :--- |
| UI-1 | La paleta institucional (`#D6EEE8` y `#0A1F8F`) está aplicada sistemáticamente sin colores fuera de marca. | [ ] | |
| UI-2 | El diseño es 100% responsivo en resoluciones móviles (320px) y escritorio (1080p). | [ ] | |
| UI-3 | Los modales de pago se superponen correctamente sin deformar el DOM subyacente. | [ ] | |
| UI-4 | El PDF generado respeta los márgenes, colores y variables del sistema. | [ ] | |

## Registro Histórico de Despliegues (CI/CD)
*Tabla a actualizar por DevOps tras cada liberación a producción.*

| Versión | Fecha | Autorizado por | Commit Hash | Estado del Despliegue |
| :--- | :--- | :--- | :--- | :--- |
| v1.0.0-rc | YYYY-MM-DD | Israel | N/A | Pendiente de Revisión |