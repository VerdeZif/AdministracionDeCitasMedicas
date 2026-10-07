# Sistema de Gestión de Citas Médicas y Pagos Online (MVP)

Plataforma web transaccional desarrollada en Laravel (PHP) y MySQL como Producto Mínimo Viable (MVP) para la automatización de reservas clínicas, administración de agendas médicas y procesamiento de pagos simulados. Diseñada bajo la arquitectura MVC para operar en la nube con altos estándares de seguridad y experiencia de usuario.

## 📌 Alcance Funcional del MVP

Este proyecto se enfoca en resolver el flujo operativo y de agendamiento de un centro médico mediante un Producto Mínimo Viable (MVP) robusto, cubriendo cinco componentes clave:

1. **Control de Acceso y Seguridad (Middlewares):** Autenticación de personal y pacientes con perfiles diferenciados (Administrador, Médico y Paciente). Implementa retención de sesión activa, encriptación Bcrypt nativa y bloqueo estricto de rutas a través de middlewares (`CheckAdmin`, `CheckDoctor`, `CheckPatient`) para evitar vulneraciones por URL.
2. **Landing Page Dinámica (UI/UX Corporativa):** Sitio web público con 4 vistas conectadas a la base de datos (Inicio, Servicios, Especialistas, Contáctenos). Interfaz estructurada bajo una paleta estricta: `#D6EEE8` (verde agua claro para fondos generales), `#0A1F8F` (azul marino oscuro para textos y bordes) y verde esmeralda para los botones de conversión (Call to Action).
3. **Portal del Paciente y Agendamiento Inteligente:** Registro autónomo con validación estricta de términos (reCAPTCHA simulado). Formulario de reserva con autocompletado de datos personales en modo "solo lectura" para proteger la integridad del perfil. Incluye un calendario interactivo con filtros de sede, especialidad y médico, validando en tiempo real la disponibilidad de turnos.
4. **Simulador de Pasarela de Pagos (Interfaces PHP):** Interfaz modal asíncrona para simular cobros con Tarjeta o Billetera Digital. Orquestado mediante el patrón de diseño de Interfaces (`PaymentGatewayInterface`), lo que permite escalar a una pasarela real (MercadoPago/Niubiz) sin reescribir controladores. Ejecuta transacciones atómicas (`DB::transaction()`) para confirmar la cita y emitir un Comprobante de Reserva Interno en formato PDF simultáneamente.
5. **Dashboards Operativos (Paneles de Control):**
   * **Administrador:** KPIs de ingresos (filtrados por método de pago simulado), auditoría general de boletas, CRUD dinámico de especialidades y alta segura de cuentas médicas.
   * **Médico:** Agenda diaria interactiva, actualización de estados de cita ("En curso", "Atendida") y gestión de disponibilidad de horarios en tiempo real.

## 👥 Equipo y Distribución de Responsabilidades (MVC + DevOps)

El proyecto sigue una estricta separación de responsabilidades bajo el patrón Modelo - Vista - Controlador (MVC):

| Integrante | Rol | Capa / Responsabilidad | Documento de Rol | Carpeta Asignada |
| :--- | :--- | :--- | :--- | :--- |
| **Jybran** | Modelo / Base de Datos | Scripts de migraciones, Seeders, relaciones Eloquent y diseño relacional en MySQL. | `rol_jybran.md` | `database/`, `app/Models/` |
| **Fernando** | Vista / Interfaz Gráfica | Plantillas Blade, UI/UX (Paleta `#D6EEE8` / `#0A1F8F`), modales y diseño responsivo. | `rol_fernando.md` | `resources/views/`, `public/` |
| **Raquel** | Controlador / Lógica | Reglas de negocio, Middlewares de seguridad, rutas web y transacciones atómicas de pago. | `rol_raquel.md` | `app/Http/Controllers/`, `routes/` |
| **Israel** | Líder / QA y DevOps | Arquitectura inicial, validación de PRs, flujos CI/CD en GitHub Actions y documentación oficial. | `rol_israel.md` | `docs/`, `.github/` |

## 🚀 Guía de Instalación y Puesta en Marcha

Sigue estos pasos en tu computadora para configurar el entorno de trabajo:

**1. Clonar el repositorio**

Abre una terminal (PowerShell o Git Bash) y clona el proyecto:
```bash
git clone https://github.com/TuUsuario/citas-medicas.git
cd citas-medicas
```

**2. Instalar las dependencias oficiales**

Con el entorno base clonado, instala las librerías del backend (PHP) y frontend (JS/CSS):
```bash
composer install
npm install
```

**3. Configurar las variables de entorno (.env)**

Para mantener aisladas y seguras las credenciales de base de datos de cada desarrollador:
Copia el archivo `.env.example` y renómbralo como `.env`:
```bash
cp .env.example .env
```
Abre el archivo `.env` y verifica tus credenciales de XAMPP (`DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_USERNAME=root`, `DB_PASSWORD=`, `DB_DATABASE=citas_medicas_bd`). 
Genera la clave de encriptación de la aplicación:
```bash
php artisan key:generate
```
*Nota: El archivo `.env` está registrado en `.gitignore`, por lo que nunca se subirá a GitHub, protegiendo tu configuración local.*

**4. Configurar la Base de Datos en MySQL (XAMPP)**

* Inicia Apache y MySQL desde el panel de control de XAMPP.
* Ingresa a phpMyAdmin en tu navegador (`http://localhost/phpmyadmin`).
* Crea la base de datos `citas_medicas_bd`.

**5. Ejecutar Migraciones y Poblado de Datos**

Con la base de datos iniciada, levanta la estructura de tablas relacionales y los datos de prueba (Seeders):
```bash
php artisan migrate --seed
```

**6. Ejecutar la aplicación**

Necesitas levantar dos servidores locales en paralelo (usa dos pestañas en tu terminal):
```bash
# Terminal 1: Servidor PHP (Backend)
php artisan serve

# Terminal 2: Servidor Vite (Compilador Frontend CSS/JS)
npm run dev
```

**7. Credenciales de acceso de prueba:**
* **Administrador:** Usuario: `admin@clinica.com` | Contraseña: `password`
* **Médico:** Usuario: `doctor@clinica.com` | Contraseña: `password`
* **Paciente:** Usuario: `paciente@correo.com` | Contraseña: `password`

## 📂 Estructura del Repositorio y Arquitectura

```text
citas-medicas/
│
├── .env.example                # Plantilla pública de variables de entorno para MySQL y APIs
├── .gitignore                  # Excluye vendor/, node_modules/ y .env del repositorio
├── README.md                   # Esta guía general
├── composer.json               # Dependencias de backend PHP (dompdf, etc.)
├── package.json                # Dependencias de frontend JS/CSS (Tailwind, Vite)
│
├── app/                        # NÚCLEO DE LÓGICA Y DATOS
│   ├── Http/Controllers/       # Controladores divididos por rol (Raquel)
│   ├── Http/Middleware/        # Filtros de protección de rutas web (Raquel)
│   ├── Interfaces/             # Contratos para pasarelas de pago escalables
│   ├── Services/               # Lógica del simulador de cobros
│   └── Models/                 # Entidades y relaciones Eloquent (Jybran)
│
├── database/                   # PERSISTENCIA (Jybran)
│   ├── migrations/             # Scripts DDL (Users, Appointments, Invoices, Specialties)
│   └── seeders/                # Datos semilla para pruebas iniciales
│
├── resources/views/            # INTERFAZ GRÁFICA BLADE (Fernando)
│   ├── public/                 # Vistas de la Landing Page (Home, Contacto)
│   ├── patient/                # Dashboard del paciente, formulario de reserva y modal de pago
│   ├── doctor/                 # Dashboard de agenda médica
│   ├── admin/                  # Dashboard de control general y auditoría
│   └── layouts/                # Plantillas maestras con paleta corporativa
│
├── routes/                     
│   └── web.php                 # Mapeo de rutas públicas y grupos protegidos por Middleware
│
└── docs/                       # DOCUMENTACIÓN TÉCNICA OFICIAL Y AUDITORÍA (Israel)
    ├── El_proyecto.md          # Visión global del sistema, alcance y limitaciones
    ├── manual_tecnico.md       # Reglas de UI corporativa y nomenclatura MVC
    ├── reglas_negocio.md       # Reglas operativas (concurrencia de fechas, inmutabilidad)
    ├── informe_auditoria_integracion.md # Auditoría de calidad y validación de Pull Requests
    ├── rol_israel.md           # Entregables de Líder/QA y DevOps
    ├── rol_raquel.md           # Entregables de Controladores y Seguridad
    ├── rol_fernando.md         # Entregables de Vistas y UI/UX
    └── rol_jybran.md           # Entregables de Modelos y Base de Datos
```

## 📖 Documentación Técnica Oficial

Para un análisis exhaustivo de la ingeniería de software detrás del proyecto, consulta los documentos especializados en la carpeta `docs/`:

* **Fundamentos de Ingeniería y UI/UX:** Consulta `manual_tecnico.md` para la explicación de la adopción del patrón de Interfaces en los pagos y las reglas estrictas de diseño visual orientadas a plataformas de salud.
* **Reglas de Negocio Operativas:** En `reglas_negocio.md` (Validación estricta de cruces de horarios, protección de rutas aisladas y flujo atómico de pagos).
* **Gestión de Integración y Calidad (QA):** En `informe_auditoria_integracion.md`.

