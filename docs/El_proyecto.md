# Alcance, Arquitectura y Visión Global del Sistema

## 1. Definición y Propósito del Producto
El "Sistema Web de Gestión de Citas Médicas y Consultas" (*Healthy Life Medical Clinic*) es una plataforma transaccional de arquitectura MVC construida sobre Laravel 12 y MySQL. Su propósito es automatizar y digitalizar el ciclo completo de atención médica: desde el agendamiento autónomo por parte de pacientes o sus dependientes, la gestión de agendas y bloqueos por parte del staff médico, hasta el registro clínico de diagnósticos e indicaciones al concluir cada cita.

## 2. Desglose de Módulos (Alcance Funcional Realizado)

### A. Módulo Público
- **Landing Page Dinámica:** Directorios de especialidades y staff médico conectados en tiempo real a la base de datos institucional.
- **Autenticación Dividida:** Formularios de acceso y registro estructurados en pantalla dividida (estilo moderno) con protecciones anti-spam y validaciones dinámicas.

### B. Módulo del Paciente (Autoservicio)
- **Registro Seguro:** Validaciones estrictas en formularios (DNI exacto de 8 dígitos, Carné de extranjería, restricción de números en nombres, teléfonos móviles válidos de 9 dígitos).
- **Gestión de Dependientes:** Registro de familiares (hijos, padres) para agendar citas directamente a su nombre, manteniendo el control bajo una cuenta principal.
- **Motor de Reservas:** Filtro en cascada y selección de turnos cruzando disponibilidad contra los bloqueos del médico.
- **Historial y Detalle de Consultas:** Visualización de citas con estados actualizados, motivos de cancelación (si aplica), diagnósticos, controles recomendados y descarga de comprobantes en PDF.

### C. Módulo del Médico (Gestión Clínica)
- **Gestión de Agenda:** Panel de control (*Dashboard*) para visualizar citas del día y pasadas. Incorpora un sistema de alertas amarillas para citas que el médico olvidó cerrar en fechas anteriores.
- **Ciclo de Atención:** Transición secuencial de estados. El médico puede iniciar la consulta (`En Curso`), finalizarla (`Atendida`) ingresando diagnóstico e instrucciones, o marcar al paciente como `Ausente`.
- **Cancelaciones:** El médico puede cancelar citas (Confirmadas o Pendientes) justificando el motivo obligatoriamente. Si el paciente ya pagó, se levanta una bandera de `refund_pending` (reembolso pendiente).
- **Bloqueo de Horarios:** Módulo para restringir fechas y turnos, con validación que impide bloquear horas donde ya existen citas confirmadas.

### D. Módulo del Administrador (Backoffice)
- **Auditoría Operativa:** Panel central para supervisar el flujo de boletas, citas canceladas y control de solicitudes de reembolso.
- **Gestión de Catálogos (CRUD):** 
  - Altas, bajas (Soft Deletes) y modificaciones de Sedes, Especialidades y cuentas de Médicos.
  - El borrado lógico impide que se rompa la integridad referencial histórica de las citas pasadas.

## 3. Limitaciones Técnicas (Fuera del Alcance)
- **EHR Completo:** No es un sistema de Historias Clínicas Electrónicas masivo (no incluye subida de DICOM, rayos X o laboratorios detallados), es un registro de atenciones orientado a la consulta ambulatoria.
- **Integración Contable Directa:** No conecta con SUNAT/Entidad Fiscal. El comprobante de reserva es un documento de uso interno.