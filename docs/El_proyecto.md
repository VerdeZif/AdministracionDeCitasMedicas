# Alcance, Arquitectura y Visión Global del Sistema (MVP)

## 1. Definición y Propósito del Producto
El "Sistema Web de Gestión de Citas Médicas y Pagos Online" es una plataforma transaccional de arquitectura MVC (Modelo-Vista-Controlador) construida sobre Laravel (PHP) y MySQL. Su propósito principal es eliminar la fricción en el agendamiento manual y telefónico, digitalizando el ciclo completo del paciente: desde la captación en la web pública, pasando por la selección autónoma de turnos, hasta la confirmación mediante un pago simulado y la emisión de un comprobante interno.

## 2. Desglose de Módulos (Alcance Funcional)

### A. Módulo Público (Landing Page Dinámica)
- **Home:** Hero section con Call to Actions (CTA) directos. Panel de métricas e indicadores de confianza.
- **Directorio Médico y Especialidades:** Catálogos alimentados dinámicamente desde la base de datos (no estáticos).
- **Contacto:** Formulario enlazado a un controlador que almacena o envía correos informativos.

### B. Módulo del Paciente (Autoservicio)
- **Registro y Perfil:** Creación de cuenta con verificación de contraseñas. El perfil centraliza los datos (DNI, Nombres, Teléfono) para evitar redundancia en futuras reservas.
- **Motor de Reservas:** 
  - Filtro en cascada: `Sede -> Especialidad -> Médico`.
  - Calendario asíncrono que evalúa cruces de horarios en la base de datos.
- **Pasarela de Pagos (Fase Mock):** Interfaz modal superpuesta (popup) que procesa transacciones virtuales para confirmar la reserva de manera inmediata.

### C. Módulo del Médico (Gestión Clínica)
- **Panel de Control (Dashboard):** Interfaz restringida para visualizar la agenda diaria y semanal.
- **Control de Estados:** Botonera ágil para marcar citas como `En Curso`, `Atendida` o `Ausente`.

### D. Módulo del Administrador (Backoffice)
- **Auditoría Transaccional:** Tabla central de boletas y citas con filtros de búsqueda por DNI o Código de Reserva.
- **Gestión de Catálogos (CRUD):** Creación, edición y eliminación (Soft Deletes) de Especialidades, Sedes y Personal Médico.

## 3. Limitaciones Técnicas y Operativas (Fuera del Alcance)
- **Sistema de Historias Clínicas Electrónicas (EHR):** No se desarrollarán módulos para registro de triaje (presión arterial, peso), notas de evolución médica (SOAP), ni carga de archivos DICOM (Radiografías) o PDFs de laboratorio.
- **Módulo Contable y Facturación Fiscal:** Las boletas generadas en formato PDF (`invoices`) funcionan como control de caja interno. No existe API de conexión con la entidad tributaria nacional para validación de firmas digitales o emisión de comprobantes fiscales.
- **Atención Síncrona:** El sistema no integra motores de videollamada (WebRTC) ni chats de soporte en vivo. Toda reserva es para atención física en sede.