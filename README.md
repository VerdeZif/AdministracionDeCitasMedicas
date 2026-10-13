# Sistema de Gestión de Citas Médicas y Consultas (Healthy Life Medical Clinic)

Plataforma web transaccional integral desarrollada en **Laravel 12** (PHP 8.2) y **MySQL** para la automatización de reservas clínicas, administración de agendas médicas, control de estados de citas y registro de consultas. 

Diseñada bajo la estricta arquitectura MVC, orientada a la seguridad, con validación de formularios en tiempo real y una identidad visual corporativa unificada.

---

## 🛠 Stack Tecnológico
* **Backend:** Laravel 12, PHP 8.2
* **Base de Datos:** MySQL 8+
* **Frontend:** Blade, Tailwind CSS, JavaScript nativo
* **Compilador de Assets:** Vite
* **Herramientas de Exportación:** Barryvdh/Laravel-DomPDF

---

## 📌 Alcance Funcional del Sistema

El sistema cubre de manera robusta los flujos operativos de un centro médico moderno a través de cinco componentes principales:

1. **Control de Acceso y Seguridad (Middlewares):** 
   - Autenticación segura y perfiles diferenciados (`admin`, `doctor`, `patient`).
   - Bloqueo estricto de rutas a través de middlewares (`CheckAdmin`, `CheckDoctor`, `CheckPatient`) para evitar suplantación de roles por URL.
2. **Landing Page y UI/UX Corporativa:** 
   - Sitio web público conectado a la base de datos (Especialidades, Staff Médico, Sedes).
   - Identidad visual clínica estricta: **Azul marino (`#22396b`)**, **Turquesa (`#4DB6AC`)** y **Fondo orgánico (`#F4F9F8`)**. Cero uso de degradados o colores no autorizados (ej. naranja).
   - Experiencia de autenticación moderna (Split-screen) envuelta en tarjetas blancas responsivas para móviles.
3. **Portal del Paciente y Registro Clínico:** 
   - Registro autónomo con validación estricta de entradas vía HTML5 y JS (bloqueo de números en nombres, restricción exacta de 8 dígitos para DNI, 9 para teléfonos).
   - Motor de reservas inteligente con filtros por sede, especialidad y médico, evitando colisiones de agenda.
   - Gestión de **dependientes (familiares)** para agendar citas directamente a su nombre.
   - Pasarela de pagos simulada (Interfaces PHP) con generación automática de Comprobante de Reserva Interno en formato PDF.
4. **Panel Médico Avanzado:** 
   - Agenda diaria e histórica con indicadores de citas pendientes de cierre.
   - Gestión completa del ciclo de la cita: *Pendiente de Pago → Confirmada → En Curso → Atendida* o *Ausente*.
   - Cancelaciones con justificación obligatoria (genera bandera de `refund_pending` si ya existía pago).
   - Registro clínico al finalizar la consulta (*diagnóstico, indicaciones y fecha de control opcional*).
   - Módulo de bloqueo de horarios (Doctor Blocks) con validación automática anti-conflictos.
5. **Panel Administrativo (Backoffice):** 
   - Dashboard operativo y auditoría general de citas y boletas.
   - Gestión de catálogos (CRUD completo y SoftDeletes) para Especialidades, Sedes y Cuentas del personal médico.

---

## 👥 Equipo y Distribución de Responsabilidades (MVC)

| Integrante | Rol | Capa / Responsabilidad | Carpeta Asignada |
| :--- | :--- | :--- | :--- |
| **Jybran** | Modelo / DB | Migraciones DDL, Seeders, relaciones Eloquent y diseño relacional en MySQL. | `database/`, `app/Models/` |
| **Fernando** | Vista / UI | Plantillas Blade, UI/UX (Paleta corporativa institucional) y diseño responsivo. | `resources/views/`, `public/` |
| **Raquel** | Controlador | Reglas de negocio, middlewares de seguridad, Controladores y patrón de Interfaces. | `app/Http/Controllers/`, `routes/` |
| **Israel** | Líder / DevOps | Arquitectura general, validación de flujos, integración QA y documentación. | `docs/`, `.github/` |

---

## 📂 Estructura Exhaustiva del Repositorio

```text
citas-medicas/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           # Controladores de autenticación adaptados (Registro extendido)
│   │   │   ├── Admin/          # SpecialtyController, HeadquarterController, DoctorManagementController
│   │   │   ├── Doctor/         # DoctorAppointmentController, DoctorBlockController
│   │   │   └── Patient/        # PatientConsultationController, AppointmentController (reservas)
│   │   └── Middleware/         # Filtros de protección: CheckAdmin, CheckDoctor, CheckPatient
│   ├── Interfaces/             # PaymentGatewayInterface (Patrón para el simulador de pagos)
│   ├── Services/               # MockPaymentService (Lógica de cobro simulado)
│   └── Models/                 # Modelos ORM: User, Appointment, Specialty, Headquarter, Dependent...
│
├── database/
│   ├── migrations/             # DDL con claves foráneas, columnas anulables, metadatos y SoftDeletes
│   └── seeders/                # DatabaseSeeder (Carga de Especialidades, Sedes y Usuarios semilla)
│
├── public/
│   └── img/                    # Assets estáticos corporativos (logo.png, logo2.png transparente)
│
├── resources/
│   ├── css/ & js/              # Hojas de estilo Tailwind y scripts procesados por Vite
│   └── views/
│       ├── admin/              # CRUDs administrativos y panel de auditoría
│       ├── auth/               # Formularios divididos (Split-screen) con validaciones nativas
│       ├── doctor/             # Agenda médica, cierre clínico y bloqueo de horarios
│       ├── layouts/            # Plantillas maestras: app.blade.php (panel), guest.blade.php (Auth)
│       └── patient/            # Pasarela de reservas, gestión de dependientes y detalles clínicos
│
├── routes/
│   └── web.php                 # Mapeo unificado de rutas protegidas por grupos y prefijos de rol
│
├── docs/                       # DOCUMENTACIÓN TÉCNICA OFICIAL
│   ├── El_proyecto.md          # Visión global y alcance
│   ├── manual_tecnico.md       # Reglas de identidad visual, diagrama ER (Mermaid) y arquitectura
│   ├── reglas_negocio.md       # Validaciones anti-colisión, inmutabilidad y transacciones atómicas
│   ├── informe_auditoria_integracion.md # Matriz QA de despliegue
│   └── rol_*.md                # Entregables individuales de los desarrolladores
│
├── .env.example                # Plantilla pública de variables de entorno para MySQL
├── composer.json               # Dependencias de backend PHP (Laravel, DomPDF)
└── package.json                # Dependencias de frontend JS/CSS (Tailwind, Vite)
```

---

## 🚀 Guía de Instalación y Puesta en Marcha

Para levantar este proyecto en un entorno de desarrollo local (XAMPP/MAMP/Laragon), sigue estos pasos:

**1. Clonar el repositorio y entrar a la carpeta**
```bash
git clone https://github.com/TuUsuario/citas-medicas.git
cd citas-medicas
```

**2. Instalar dependencias del Backend y Frontend**
```bash
composer install
npm install
```

**3. Configurar entorno (.env)**
Copia el archivo de ejemplo y genera tu llave criptográfica:
```bash
cp .env.example .env
php artisan key:generate
```
*Abre el archivo `.env` resultante y configura los credenciales de tu base de datos MySQL local (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).*

**4. Estructurar la Base de Datos y Poblar Datos Semilla**
Este comando ejecutará todas las migraciones y cargará especialidades, sedes y los usuarios de prueba:
```bash
php artisan migrate:fresh --seed
```

**5. Levantar el ecosistema (Servidores Locales)**
Necesitas ejecutar ambos comandos en paralelo (utiliza dos pestañas de terminal):
```bash
# Terminal 1: Servidor PHP (Backend)
php artisan serve

# Terminal 2: Servidor Vite (Compilador Frontend)
npm run dev
```

**6. Acceder al sistema**
Abre tu navegador en `http://127.0.0.1:8000`. Puedes ingresar con las siguientes credenciales (generadas por el seeder):
* **Admin:** `admin@healthylife.com` | Password: `password`
* **Médico:** `doctor@healthylife.com` | Password: `password`
* **Paciente:** `israel@healthylife.com` | Password: `password`