# Manual de Ingeniería, Estandarización y Flujo de Trabajo

## 1. Reglas de Interfaz Gráfica (UI/UX) - (Para Fernando)
La identidad visual de *Healthy Life Medical Clinic* es estricta. Queda absolutamente prohibido el uso de degradados o paletas ajenas a las establecidas (específicamente, prohibido el uso del color naranja).

- **Color Base Global (Fondos):** Verde agua claro `#F4F9F8`.
- **Color Primario (Textos/Cabeceras/Modales):** Azul marino `#22396b`.
- **Color de Acento (Bordes/Botones principales):** Turquesa `#4DB6AC`.
- **Tarjetas y Contenedores:** Fondo blanco puro, con sombra suave (`shadow-md`), bordes redondeados (`rounded-xl`) y borde superior/izquierdo en color turquesa o azul marino para destacar jerarquía.

## 2. Nomenclatura Estricta del Código
- **Base de Datos:** Tablas en inglés, minúsculas y plural (`users`, `appointments`, `specialties`, `headquarters`, `dependents`, `doctor_blocks`).
- **Modelos:** PascalCase singular (`User`, `Appointment`).
- **Controladores:** PascalCase con sufijo correspondiente (`DoctorAppointmentController`, `PatientConsultationController`).
- **Vistas (Blade):** Organizadas en subcarpetas lógicas (`doctor/blocks/index.blade.php`, `patient/appointments/show.blade.php`).

## 3. Arquitectura de Base de Datos (Modelo ER)
A continuación se documenta el Diagrama Entidad-Relación actualizado (soportado por Mermaid.js) que rige el sistema:

```mermaid
erDiagram
    USERS {
        bigint id PK
        string document_type
        string dni UK
        string name
        string last_name_paternal
        string last_name_maternal
        string email UK
        date birth_date
        string phone
        char gender
        string password
        string role "admin, doctor, patient"
        bigint specialty_id FK "nullable"
    }
    SPECIALTIES {
        bigint id PK
        string name
        text description
        string image_path
    }
    HEADQUARTERS {
        bigint id PK
        string name
        string address
        string phone
    }
    DEPENDENTS {
        bigint id PK
        bigint patient_id FK
        string full_name
        string dni
    }
    APPOINTMENTS {
        bigint id PK
        bigint patient_id FK
        bigint dependent_id FK "nullable"
        bigint doctor_id FK
        bigint headquarter_id FK
        bigint specialty_id FK
        date date
        string time
        string status "Pendiente de Pago, Confirmada, En Curso, Atendida, Ausente, Cancelada"
        text diagnosis
        text instructions
        date follow_up_date
        timestamp attended_at
        string cancelled_by
        text cancellation_reason
        boolean refund_pending
    }
    DOCTOR_BLOCKS {
        bigint id PK
        bigint doctor_id FK
        date date
        string start_time
        string end_time
        text reason
    }

    USERS ||--o{ APPOINTMENTS : "agenda (paciente)"
    USERS ||--o{ APPOINTMENTS : "atiende (doctor)"
    USERS ||--o{ DEPENDENTS : "registra familiar"
    USERS }o--|| SPECIALTIES : "pertenece a"
    SPECIALTIES ||--o{ APPOINTMENTS : "clasifica"
    HEADQUARTERS ||--o{ APPOINTMENTS : "alberga"
    DEPENDENTS ||--o{ APPOINTMENTS : "asiste a"
    USERS ||--o{ DOCTOR_BLOCKS : "bloquea agenda"
```