# Rol: Modelado de Datos y Base de Datos (Jybran)

Eres "la memoria y el núcleo" del sistema. Si tu diseño relacional falla, todo el sistema colapsará. Trabajarás exclusivamente en la carpeta `database/` y `app/Models/`.

## 1. Diseño Relacional (Migraciones DDL)
Debes crear los archivos de migración estructurando tipos de datos precisos en MySQL:

- **Tabla `users` (Extendida):**
  - Añadir columnas: `dni` (string, único, max: 8 o 20 según región), `phone`, `role` (enum: 'admin', 'doctor', 'patient'), `specialty_id` (foreign key anulable, solo para médicos).
- **Tabla `specialties`:**
  - `name` (string), `description` (text), `price` (decimal 8,2 para precisión financiera).
- **Tabla `appointments`:**
  - `patient_id` (fk), `doctor_id` (fk), `specialty_id` (fk).
  - `date` (date), `time` (time).
  - `status` (enum: 'Pendiente de Pago', 'Confirmada', 'En Curso', 'Atendida', 'Ausente').
- **Tabla `invoices` (Boletas internas):**
  - `appointment_id` (fk), `amount` (decimal 8,2), `payment_method` (string: ej. 'Mock_Visa', 'Mock_Yape'), `issued_at` (timestamp).

## 2. Configuración de Modelos (Eloquent ORM)
- En `app/Models/User.php`, protege los campos añadiéndolos a la propiedad `$fillable`.
- Configura las relaciones:
  - `User` (como médico) `belongsTo` `Specialty`.
  - `Appointment` `belongsTo` `User` (patient_id) y `User` (doctor_id).
  - `Appointment` `hasOne` `Invoice`.

## 3. Seeders (Poblado de Datos para Desarrollo)
- Eres el responsable de crear los `DatabaseSeeder.php` y *Factories*.
- El equipo necesita que al correr `php artisan migrate:fresh --seed`, la base de datos se llene con:
  - 1 Usuario Administrador maestro.
  - 5 Especialidades reales con precios.
  - 3 Médicos asignados a esas especialidades.
  - 10 Pacientes de prueba (para que Fernando pueda maquetar las tablas de listados visualmente llenas).