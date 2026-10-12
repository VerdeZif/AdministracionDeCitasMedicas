<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Reserva</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { background-color: #D6EEE8; padding: 20px; text-align: center; border-bottom: 4px solid #0A1F8F; }
        .title { color: #0A1F8F; font-size: 24px; font-weight: bold; margin: 0; }
        .content { padding: 30px; }
        .box { border: 1px dashed #0A1F8F; padding: 15px; margin-top: 20px; border-radius: 5px; }
        .row { margin-bottom: 10px; }
        .label { font-weight: bold; color: #0A1F8F; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Clínica Healthy Life</h1>
        <p>Comprobante Oficial de Reserva Médica</p>
    </div>

    <div class="content">
        <h2>Detalles de su cita</h2>
        <p>¡Hola, <strong>{{ $appointment->patient->name }}</strong>! Su cita ha sido confirmada en nuestro sistema.</p>
        
        <div class="box">
            <div class="row"><span class="label">Código de Cita:</span> #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="row"><span class="label">Fecha y Hora:</span> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</div>
            <div class="row"><span class="label">Especialidad:</span> {{ $appointment->specialty->name }}</div>
            <div class="row"><span class="label">Médico Tratante:</span> {{ $appointment->doctor->name }}</div>
            <div class="row"><span class="label">Sede:</span> {{ $appointment->headquarter->name }}</div>
            <div class="row"><span class="label">Estado de Pago:</span> PAGADO (S/ {{ number_format($appointment->specialty->price, 2) }})</div>
        </div>
    </div>

    <div class="footer">
        <p>Por favor, asista 15 minutos antes de su turno portando su DNI.</p>
        <p>Este documento es válido como constancia de atención para Healthy Life.</p>
    </div>
</body>
</html>