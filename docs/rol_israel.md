# Rol: Líder del Proyecto, QA y DevOps (Israel)

Este documento detalla las funciones exclusivas del líder técnico y orquestador del proyecto.

## 1. Arquitectura y Orquestación
- Inicialización del ecosistema Laravel, configuración de `.env.example` y división de roles.
- Documentación de Reglas de Negocio (`reglas_negocio.md`) e informe de auditoría.
- Supervisión del cumplimiento del patrón arquitectónico MVC.

## 2. Aseguramiento de Calidad (QA)
- Revisión de Pull Requests. Encargado exclusivo de fusionar a la rama `main`.
- Validación de que los desarrollos de Vistas (Fernando) y Controladores (Raquel) respeten las restricciones de diseño (eliminación de paletas no autorizadas) y la lógica de validaciones restrictivas (DNI, Celular).

## 3. Integración y Despliegue Continuo (CI/CD)
- Automatización vía GitHub Actions: Linting, tests, y despliegues.
- Ejecución segura de comandos críticos en servidor: `php artisan migrate --force`.

## 4. Evolución y Escalabilidad
- Asegurar que la estructura final de Base de Datos y las interfaces permitan en un futuro (Post-MVP) conectar el sistema con pasarelas de pago reales o módulos de facturación electrónica sin refactorizaciones destructivas.