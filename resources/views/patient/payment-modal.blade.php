<div id="modalPago" class="hidden" style="position:fixed; inset:0; z-index:9999; background:rgba(17,24,39,.6); overflow-y:auto;">
    <div style="min-height:100%; display:flex; align-items:center; justify-content:center; padding:1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full relative p-6" style="max-width:28rem;">

            {{-- Vista principal --}}
            <div id="pagoForm">
                <button type="button" onclick="cerrarPago()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">✖</button>
                <h3 class="text-xl font-bold" style="color:#22396b">Elige cómo pagar</h3>
                <p class="text-sm text-gray-500 mb-4">Total: S/ {{ number_format($appointment->specialty->price, 2) }}</p>

                {{-- Métodos --}}
                <div class="grid grid-cols-4 gap-2 mb-5" id="metodos">
                    <button type="button" data-m="tarjeta" onclick="elegirMetodo('tarjeta')" class="met-btn"><span>💳</span>Tarjeta</button>
                    <button type="button" data-m="yape" onclick="elegirMetodo('yape')" class="met-btn"><span>📱</span>Yape</button>
                    <button type="button" data-m="plin" onclick="elegirMetodo('plin')" class="met-btn"><span>📲</span>Plin</button>
                    <button type="button" data-m="pagoefectivo" onclick="elegirMetodo('pagoefectivo')" class="met-btn"><span>🏪</span>PagoEfectivo</button>
                </div>

                <form onsubmit="procesarPago(event)" class="space-y-4">

                    {{-- Tarjeta --}}
                    <div id="f-tarjeta" class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium mb-1">Nombre en la tarjeta</label>
                            <input id="card_name" class="pay-input" placeholder="JUAN PEREZ">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1">Número de tarjeta</label>
                            <input id="card_number" inputmode="numeric" maxlength="19" class="pay-input" placeholder="4242 4242 4242 4242">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium mb-1">Vence (MM/AA)</label>
                                <input id="expiry" maxlength="5" class="pay-input" placeholder="12/28">
                            </div>
                            <div>
                                <label class="block text-xs font-medium mb-1">CVV</label>
                                <input id="cvv" inputmode="numeric" maxlength="4" class="pay-input" placeholder="123">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">Prueba: 4242 4242 4242 4242 (aprobada) · 4000 0000 0000 0002 (rechazada).</p>
                    </div>

                    {{-- Yape --}}
                    <div id="f-yape" class="hidden space-y-4">
                        <div>
                            <label class="block text-xs font-medium mb-1">Celular Yape</label>
                            <input id="yape_phone" inputmode="numeric" maxlength="9" class="pay-input" placeholder="999 999 999">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1">Código de aprobación (6 dígitos)</label>
                            <input id="yape_code" inputmode="numeric" maxlength="6" class="pay-input" placeholder="123456">
                        </div>
                        <p class="text-xs text-gray-400">Prueba: cualquier código de 6 dígitos funciona; 000000 es rechazado.</p>
                    </div>

                    {{-- Plin --}}
                    <div id="f-plin" class="hidden space-y-4">
                        <div>
                            <label class="block text-xs font-medium mb-1">Celular Plin</label>
                            <input id="plin_phone" inputmode="numeric" maxlength="9" class="pay-input" placeholder="999 999 999">
                        </div>
                        <p class="text-xs text-gray-400">Simulación: al continuar se aprueba el pago como si lo hubieras confirmado en tu app.</p>
                    </div>

                    {{-- PagoEfectivo --}}
                    <div id="f-pagoefectivo" class="hidden space-y-3">
                        <p class="text-sm text-gray-600">Genera un código (CIP) y págalo en agentes, bodegas o por la banca móvil.</p>
                        <div id="cipBox" class="hidden text-center rounded-lg p-4" style="background:#E0F2F1">
                            <p class="text-xs text-gray-500">Tu código CIP</p>
                            <p id="cipCodigo" class="text-2xl font-extrabold tracking-widest" style="color:#22396b"></p>
                        </div>
                        <button type="button" id="btnCip" onclick="generarCip()" class="w-full py-2.5 rounded-md font-bold text-sm" style="border:1.5px solid #4DB6AC; color:#22396b">
                            Generar código de pago
                        </button>
                    </div>

                    <p id="pagoError" class="hidden text-sm text-red-600"></p>
                    <button type="submit" id="btnPagar" class="w-full py-3 rounded-md font-bold text-white text-sm uppercase" style="background:#4DB6AC">Pagar ahora</button>
                </form>
            </div>

            {{-- Procesando --}}
            <div id="pagoProcesando" class="hidden text-center py-12">
                <div class="mx-auto mb-4 h-10 w-10 rounded-full border-4 border-gray-200 animate-spin" style="border-top-color:#4DB6AC"></div>
                <p class="font-semibold" style="color:#22396b">Procesando pago...</p>
            </div>

            {{-- Éxito --}}
            <div id="pagoExito" class="hidden text-center py-12">
                <p class="text-5xl mb-3">✅</p>
                <p class="text-lg font-bold" style="color:#22396b">¡Pago aprobado!</p>
                <p class="text-sm text-gray-500">Tu cita quedó confirmada. Redirigiendo...</p>
            </div>
        </div>
    </div>
</div>

<style>
    .pay-input { width:100%; border:1px solid #d1d5db; border-radius:.375rem; padding:.5rem .75rem; font-size:.875rem; }
    .pay-input:focus { outline:none; border-color:#4DB6AC; box-shadow:0 0 0 2px #4DB6AC33; }
    .met-btn { border:1.5px solid #e5e7eb; border-radius:.6rem; padding:.5rem .25rem; font-size:.65rem; font-weight:600; color:#22396b; text-align:center; transition:.15s; }
    .met-btn span { display:block; font-size:1.25rem; margin-bottom:2px; }
    .met-btn:hover { border-color:#4DB6AC; }
    .met-btn.activo { border-color:#4DB6AC; background:#E0F2F1; }
</style>

<script>
    // Mueve el modal al <body> para que el footer no lo tape
    document.body.appendChild(document.getElementById('modalPago'));

    const vistasPago = ['pagoForm', 'pagoProcesando', 'pagoExito'];
    const mostrarVista = id => vistasPago.forEach(v => document.getElementById(v).classList.toggle('hidden', v !== id));
    const abrirPago = () => { mostrarVista('pagoForm'); document.getElementById('modalPago').classList.remove('hidden'); elegirMetodo(metodo); };
    const cerrarPago = () => document.getElementById('modalPago').classList.add('hidden');

    let metodo = 'tarjeta';
    let cip = '';
    const soloDigitos = (id, max) => document.getElementById(id).addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, max);
    });
    soloDigitos('yape_phone', 9); soloDigitos('yape_code', 6); soloDigitos('plin_phone', 9);

    document.getElementById('card_number').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 16).replace(/(.{4})/g, '$1 ').trim();
    });
    document.getElementById('expiry').addEventListener('input', e => {
        const v = e.target.value.replace(/\D/g, '').slice(0, 4);
        e.target.value = v.length > 2 ? v.slice(0, 2) + '/' + v.slice(2) : v;
    });

    function elegirMetodo(m) {
        metodo = m;
        document.querySelectorAll('.met-btn').forEach(b => b.classList.toggle('activo', b.dataset.m === m));
        ['tarjeta', 'yape', 'plin', 'pagoefectivo'].forEach(x =>
            document.getElementById('f-' + x).classList.toggle('hidden', x !== m));
        document.getElementById('pagoError').classList.add('hidden');
        const btn = document.getElementById('btnPagar');
        btn.innerText = m === 'pagoefectivo' ? 'Ya pagué (simular)' : 'Pagar ahora';
        btn.classList.toggle('hidden', m === 'pagoefectivo' && !cip);
    }

    function generarCip() {
        cip = String(Math.floor(10000000 + Math.random() * 90000000));
        document.getElementById('cipCodigo').innerText = cip;
        document.getElementById('cipBox').classList.remove('hidden');
        document.getElementById('btnCip').classList.add('hidden');
        document.getElementById('btnPagar').classList.remove('hidden');
    }

    function mostrarErrorPago(msg) {
        mostrarVista('pagoForm');
        const err = document.getElementById('pagoError');
        err.innerText = msg;
        err.classList.remove('hidden');
    }

    function datosPago() {
        const v = id => document.getElementById(id).value;
        if (metodo === 'tarjeta') {
            return { method: 'tarjeta', card_name: v('card_name'), card_number: v('card_number'), expiry: v('expiry'), cvv: v('cvv') };
        }
        if (metodo === 'yape') return { method: 'yape', phone: v('yape_phone'), code: v('yape_code') };
        if (metodo === 'plin') return { method: 'plin', phone: v('plin_phone') };
        return { method: 'pagoefectivo', cip };
    }

    async function procesarPago(e) {
        e.preventDefault();
        document.getElementById('pagoError').classList.add('hidden');
        mostrarVista('pagoProcesando');
        await new Promise(r => setTimeout(r, 2000)); // simula el tiempo de la pasarela

        try {
            const res = await fetch("{{ route('patient.appointments.pay', $appointment) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datosPago())
            });
            const data = await res.json();

            if (res.ok) {
                mostrarVista('pagoExito');
                setTimeout(() => window.location.href = data.redirect, 1500);
            } else if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                const primero = data.errors ? Object.values(data.errors)[0][0] : null;
                mostrarErrorPago(primero || data.message || 'No se pudo procesar el pago.');
            }
        } catch (error) {
            mostrarErrorPago('Error de conexión. Intenta de nuevo.');
        }
    }
</script>