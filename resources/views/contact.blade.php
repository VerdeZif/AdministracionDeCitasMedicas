@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-[#0A1F8F] mb-4 uppercase tracking-wider">Contáctanos</h2>
        <div class="w-16 h-1 bg-[#4DB6AC] mx-auto mb-6"></div>
        <p class="text-[#0A1F8F] font-medium max-w-2xl mx-auto text-lg opacity-80">
            Estamos listos para atender tus consultas y ayudarte a programar tu próxima cita médica.
        </p>
    </div>

    <!-- Contenedor Principal (Estilo Tarjeta Moderna) -->
    <div class="flex flex-col lg:flex-row gap-12 bg-white p-8 lg:p-12 rounded-3xl shadow-md border border-gray-100 relative overflow-hidden">
        
        <!-- Decoración de fondo suave (Mancha verde agua) -->
        <div class="absolute top-0 right-0 w-72 h-72 bg-[#D6EEE8] rounded-full mix-blend-multiply filter blur-3xl opacity-50 transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

        <!-- Columna Izquierda: Formulario -->
        <div class="lg:w-1/2 relative z-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="bg-[#D6EEE8] p-3 rounded-full text-[#0A1F8F] shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-[#0A1F8F]">Envíanos un mensaje</h3>
            </div>
            
            <form id="whatsappForm" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-[#0A1F8F] mb-2">Nombre Completo *</label>
                    <input type="text" id="wa_name" required class="w-full bg-gray-50 border-2 border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-0 focus:border-[#0A1F8F] block p-3.5 transition-colors shadow-sm outline-none">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-[#0A1F8F] mb-2">Teléfono / Celular *</label>
                        <input type="tel" id="wa_phone" required class="w-full bg-gray-50 border-2 border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-0 focus:border-[#0A1F8F] block p-3.5 transition-colors shadow-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#0A1F8F] mb-2">Sede de Interés *</label>
                        <select id="wa_sede" required class="w-full bg-gray-50 border-2 border-gray-100 text-[#0A1F8F] text-sm rounded-xl focus:ring-0 focus:border-[#0A1F8F] block p-3.5 transition-colors shadow-sm outline-none cursor-pointer">
                            <option value="">Seleccione...</option>
                            <?php if(isset($headquarters)): ?>
                                <?php foreach($headquarters as$hq): ?>
                                    <option value="{{ $hq->name }}">{{ $hq->name }}</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-[#0A1F8F] mb-2">¿Cómo podemos ayudarte? *</label>
                    <textarea id="wa_message" rows="4" required class="w-full bg-gray-50 border-2 border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-0 focus:border-[#0A1F8F] block p-3.5 transition-colors shadow-sm outline-none resize-none" placeholder="Escribe tu consulta aquí..."></textarea>
                </div>

                <!-- Botón Oficial de WhatsApp -->
                <button type="button" onclick="sendToWhatsApp()" class="w-full bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex justify-center items-center gap-3 text-lg group">
                    <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    Contactar por WhatsApp
                </button>
            </form>
        </div>

        <!-- Columna Derecha: Datos y Mapa -->
        <div class="lg:w-1/2 relative z-10 flex flex-col justify-between">
            
            <div class="mb-8 bg-gray-50/50 p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm">
                <h3 class="text-xl font-bold text-[#0A1F8F] mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-[#4DB6AC]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Sede Administrativa
                </h3>
                
                <ul class="space-y-6">
                    <li class="flex items-center">
                        <span class="bg-[#D6EEE8] p-2.5 rounded-xl text-[#0A1F8F] mr-4 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></span>
                        <div>
                            <strong class="block text-[#0A1F8F] text-sm mb-0.5">Dirección:</strong>
                            <span class="text-gray-600 text-sm font-medium">{{ isset($headquarters) && count($headquarters) > 0 ?$headquarters->first()->address : 'Av. San Carlos 1095, San Juan de Lurigancho' }}</span>
                        </div>
                    </li>
                    <li class="flex items-center">
                        <span class="bg-[#D6EEE8] p-2.5 rounded-xl text-[#0A1F8F] mr-4 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></span>
                        <div>
                            <strong class="block text-[#0A1F8F] text-sm mb-0.5">Teléfono Directo:</strong>
                            <span class="text-gray-600 text-sm font-medium">{{ isset($headquarters) && count($headquarters) > 0 ?$headquarters->first()->phone : '921 254 616' }}</span>
                        </div>
                    </li>
                    <li class="flex items-center">
                        <span class="bg-[#D6EEE8] p-2.5 rounded-xl text-[#0A1F8F] mr-4 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></span>
                        <div>
                            <strong class="block text-[#0A1F8F] text-sm mb-0.5">Correo Electrónico:</strong>
                            <span class="text-gray-600 text-sm font-medium">contacto@healthylife.com</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Mapa embebido con bordes suaves -->
            <div class="w-full h-56 sm:h-64 bg-gray-200 rounded-3xl overflow-hidden shadow-inner border-4 border-white relative flex-grow">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15610.13781297126!2d-77.016335!3d-12.008434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c5a049f53e6b%3A0xcb181db5b2447eb5!2sSan%20Juan%20de%20Lurigancho!5e0!3m2!1ses!2spe!4v1700000000000!5m2!1ses!2spe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

    </div>
</div>

<!-- Script de Envío -->
<script>
    function sendToWhatsApp() {
        const name = document.getElementById('wa_name').value;
        const phone = document.getElementById('wa_phone').value;
        const sede = document.getElementById('wa_sede').value;
        const message = document.getElementById('wa_message').value;

        if(!name || !phone || !message || !sede) {
            alert('Por favor, completa todos los campos requeridos (*).');
            return;
        }

        const clinicPhone = '51929879712'; 
        
        // Texto limpio sin emojis para evitar errores de codificación
        let text = `Hola Clínica Healthy Life, mi nombre es *${name}*.\n\n`;
        text += `*Teléfono de contacto:* ${phone}\n`;
        text += `*Sede de interés:* ${sede}\n\n`;
        text += `*Mi consulta es:*\n${message}`;

        const encodedText = encodeURIComponent(text);
        const url = `https://wa.me/${clinicPhone}?text=${encodedText}`;

        window.open(url, '_blank');
    }
</script>
@endsection