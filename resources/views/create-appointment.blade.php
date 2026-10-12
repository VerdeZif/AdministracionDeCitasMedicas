@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-brand-action">
        <div class="bg-brand-light p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-brand-dark">Reservar Nueva Cita</h2>
            <p class="text-sm opacity-75 mt-1">Sigue los pasos para agendar tu atención médica.</p>
        </div>

        <form action="{{ route('patient.appointments.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Paso 1: Selección de Clínica y Especialidad -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-brand-dark flex items-center gap-2 border-b pb-2">
                        <span class="bg-brand-dark text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">1</span> 
                        Datos Clínicos
                    </h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-brand-dark mb-1">Sede de Atención</label>
                        <select name="headquarter_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border">
                            <option value="">Selecciona una Sede...</option>
                            @foreach(\App\Models\Headquarter::all() as $headquarter)
                                <option value="{{ $headquarter->id }}">{{ $headquarter->name }} - {{ $headquarter->address }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand-dark mb-1">Especialidad</label>
                        <select name="specialty_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border">
                            <option value="">Selecciona una Especialidad...</option>
                            @foreach(\App\Models\Specialty::all() as $specialty)
                                <option value="{{ $specialty->id }}">
                                    {{ $specialty->name }} (S/ {{ number_format($specialty->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand-dark mb-1">Médico (Opcional)</label>
                        <select name="doctor_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border">
                            <option value="">Cualquier médico disponible</option>
                            @foreach(\App\Models\User::where('role', 'doctor')->get() as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialty->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Paso 2: Calendario y Horario -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-brand-dark flex items-center gap-2 border-b pb-2">
                        <span class="bg-brand-dark text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">2</span> 
                        Fecha y Hora
                    </h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-brand-dark mb-1">Fecha de la Cita</label>
                        <input type="date" name="appointment_date" required min="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand-dark mb-1">Horario Disponible</label>
                        <select name="appointment_time" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand-action focus:ring focus:ring-brand-action focus:ring-opacity-50 p-2 border">
                            <option value="">Selecciona una hora...</option>
                            <!-- Estos se poblarían con AJAX en un entorno real, aquí simulamos turnos fijos para el MVP -->
                            <option value="09:00:00">09:00 AM</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="11:30:00">11:30 AM</option>
                            <option value="14:00:00">02:00 PM</option>
                            <option value="16:00:00">04:00 PM</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Resumen y Pago -->
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h4 class="font-bold text-brand-dark">Resumen de Pago</h4>
                    <p class="text-sm opacity-75">El pago se procesará de forma segura. Selecciona tu método:</p>
                    
                    <div class="mt-2 flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_method" value="credit_card" required checked class="text-brand-action focus:ring-brand-action">
                            <span class="text-sm font-medium">💳 Tarjeta Crédito/Débito</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_method" value="digital_wallet" required class="text-brand-action focus:ring-brand-action">
                            <span class="text-sm font-medium">📱 Billetera Digital</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="w-full md:w-auto bg-brand-action hover:bg-brand-action-hover text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-all text-lg">
                    Confirmar y Pagar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection