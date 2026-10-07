# Rol: Backend, Lógica de Negocio y Seguridad (Raquel)

Eres el "cerebro" del sistema. Tu trabajo asegura que las vistas de Fernando procesen datos de manera segura y eficiente en las tablas diseñadas por Jybran.

## 1. Configuración de Rutas y Seguridad
- **Archivo Principal:** Gestionas `routes/web.php`.
- **Agrupamiento:** Debes crear grupos de rutas con prefijos (`/admin`, `/doctor`, `/patient`) y protegerlos utilizando middlewares.
- **Middlewares a crear:**
  - `CheckAdmin`: Verifica que `Auth::user()->role === 'admin'`.
  - `CheckDoctor`: Verifica que `Auth::user()->role === 'doctor'`.
  - `CheckPatient`: Verifica que `Auth::user()->role === 'patient'`.

## 2. Controladores (Lógica Transaccional)
- `PageController`: Carga las vistas públicas (Home, Servicios, Especialistas). Consulta la BD para mandar a la vista los médicos activos.
- `AppointmentController`: Contiene la lógica pesada. 
  - **Método Store:** Valida que el paciente no intente alterar sus propios datos (RN-02). Valida que el médico tenga el horario libre (RN-03). Retorna un estado JSON para que el frontend abra el modal de pago.
- `PaymentController`:
  - Recibe el clic del modal de pagos.
  - Implementa obligatoriamente un bloque `try-catch` envolviendo un `DB::transaction()`.
  - Cambia la cita a `Confirmada`, crea la fila en `invoices`.
  - Genera y retorna el PDF de la boleta.

## 3. Patrón de Diseño (Pasarela de Pagos)
- Define el contrato en `app/Interfaces/PaymentGatewayInterface.php` con al menos el método `public function processPayment(array $data);`.
- Implementa la lógica simulada en `app/Services/MockPaymentService.php` retornando un array de éxito. Esto prepara el sistema para el mundo real.

## 4. Generación de PDF
- Utilizar el paquete `barryvdh/laravel-dompdf`. 
- Alimentar la vista del comprobante interno pasándole los objetos completos del Paciente, la Cita y el Médico mediante Eloquent.