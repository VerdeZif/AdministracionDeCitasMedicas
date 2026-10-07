# Rol: Líder del Proyecto, QA y DevOps (Israel)

Este documento detalla las funciones exclusivas del líder técnico y orquestador del proyecto.

## 1. Arquitectura y Orquestación Inicial
- Responsable de la ejecución de los comandos base: inicialización de Laravel, configuración del archivo `.env.example`, y definición del árbol de directorios para aislar las capas MVC.
- Diseño y validación del documento de Reglas de Negocio.

## 2. Aseguramiento de Calidad (QA) y Code Review
- **Auditor de Pull Requests (PR):** Ningún código se integra a la rama `main` sin la revisión línea por línea de Israel.
- **Resolución de Conflictos:** En caso de conflictos de fusión (Merge Conflicts) entre las vistas de Fernando y los controladores de Raquel, Israel lidera la sesión de refactorización.
- Ejecución periódica del `informe_auditoria_integracion.md`.

## 3. Integración y Despliegue Continuo (CI/CD)
- **GitHub Actions:** Configuración de un pipeline `.yml` en la carpeta `.github/workflows/` que automatice:
  1. La validación de sintaxis PHP (Linting).
  2. La instalación de dependencias en un entorno virtual efímero (`composer install`, `npm build`).
  3. El despliegue automatizado hacia el servidor de producción (VPS o Hosting) vía SSH.
  4. La ejecución de las migraciones de producción (`php artisan migrate --force`).

## 4. Visión de Escalabilidad
- Garantizar que la arquitectura de software construida por el equipo soporte el reemplazo del simulador de pagos por una API real (MercadoPago/Stripe) en las fases posteriores del proyecto sin generar deuda técnica.