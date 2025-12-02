<div>
    <h2 class="text-2xl font-bold text-[#1e5128] mb-6">Escanear Cupón y Registrar Venta</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Código del Cupón (Escaneado o Ingresado Manualmente)</label>
            <div class="flex space-x-2">
                <input type="text" wire:model="scannedCode" 
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e5128] focus:border-[#1e5128]"
                    placeholder="Ingrese o escanee el código del cupón">
                <button wire:click="scanCoupon" 
                    class="bg-[#1e5128] text-white px-6 py-2 rounded-lg hover:bg-[#1a4520] transition">
                    Buscar Cupón
                </button>
            </div>
        </div>

        <!-- QR Scanner Placeholder -->
        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
            <div class="flex justify-between items-center mb-2">
                <p class="text-sm text-gray-600">Escáner de Cámara (Requiere permisos)</p>
                <button type="button" id="start-scanner-btn" 
                    class="bg-[#bc9313] text-white px-4 py-2 rounded-lg hover:bg-[#a0800f] transition text-sm">
                    Iniciar Escáner
                </button>
                <button type="button" id="stop-scanner-btn" 
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm hidden">
                    Detener Escáner
                </button>
            </div>
            <div id="qr-reader" style="width: 100%; min-height: 300px;"></div>
            <div id="scanner-status" class="text-sm text-gray-500 mt-2"></div>
        </div>
    </div>

    @if($coupon && !$coupon->isUsed())
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-[#1e5128] mb-4">Información del Cupón</h3>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-600">Código:</p>
                    <p class="font-mono font-bold text-lg">{{ $coupon->code }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Cliente:</p>
                    <p class="font-medium">{{ $coupon->lead->name }}</p>
                    <p class="text-sm text-gray-500">{{ $coupon->lead->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Influencer:</p>
                    <p class="font-medium">{{ $coupon->lead->influencer->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Descuento Aplicable:</p>
                    <p class="font-bold text-[#bc9313]">{{ $coupon->lead->influencer->discount_percent ?? 0 }}%</p>
                </div>
            </div>
        </div>
    @endif

    @if($showSaleForm && $coupon && !$coupon->isUsed())
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-[#1e5128] mb-4">Registrar Venta</h3>
            <form wire:submit.prevent="registerSale" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Monto de la Venta</label>
                    <input type="number" step="0.01" wire:model="saleAmount" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e5128] focus:border-[#1e5128]">
                    @error('saleAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notas (Opcional)</label>
                    <textarea wire:model="notes" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e5128] focus:border-[#1e5128]"></textarea>
                </div>

                @if($saleAmount)
                    @php
                        $discount = ($coupon->lead->influencer->discount_percent ?? 0);
                        $discountAmount = (floatval($saleAmount) * $discount) / 100;
                        $commission = ($coupon->lead->influencer->commission_percent ?? 0);
                        $commissionAmount = (floatval($saleAmount) * $commission) / 100;
                    @endphp
                    <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                        <div class="flex justify-between">
                            <span>Descuento ({{ $discount }}%):</span>
                            <span class="font-semibold text-[#bc9313]">-${{ number_format($discountAmount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Comisión para Influencer ({{ $commission }}%):</span>
                            <span class="font-semibold text-[#1e5128]">${{ number_format($commissionAmount, 2) }}</span>
                        </div>
                    </div>
                @endif

                <div class="flex space-x-3">
                    <button type="submit" 
                        class="flex-1 bg-[#1e5128] text-white px-6 py-2 rounded-lg hover:bg-[#1a4520] transition">
                        Registrar Venta
                    </button>
                    <button type="button" wire:click="resetForm"
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@latest"></script>
<script>
    (function() {
        let html5QrCode = null;
        let isScanning = false;
        let componentId = null;
        let startBtn, stopBtn, statusDiv;
        
        function init() {
            startBtn = document.getElementById('start-scanner-btn');
            stopBtn = document.getElementById('stop-scanner-btn');
            statusDiv = document.getElementById('scanner-status');
            
            // Check browser support
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                updateStatus('Tu navegador no soporta el acceso a la cámara. Usa Chrome, Firefox o Edge actualizado.', true);
                if (startBtn) startBtn.disabled = true;
                return;
            }
            
            // Wait for Livewire to initialize
            if (window.Livewire) {
                Livewire.hook('mounted', ({ component }) => {
                    componentId = component.id;
                });
                
                // Try to get component ID from DOM
                setTimeout(() => {
                    const component = document.querySelector('[wire\\:id]');
                    if (component) {
                        componentId = component.getAttribute('wire:id');
                    }
                }, 500);
            }
            
            // Button event listeners
            if (startBtn) {
                startBtn.addEventListener('click', startScanner);
            }
            
            if (stopBtn) {
                stopBtn.addEventListener('click', stopScanner);
            }
        }
        
        // Get component ID from Livewire
        function getComponentId() {
            if (!componentId && window.Livewire) {
                const component = document.querySelector('[wire\\:id]');
                if (component) {
                    componentId = component.getAttribute('wire:id');
                }
            }
            return componentId;
        }
        
        function updateStatus(message, isError = false) {
            if (statusDiv) {
                statusDiv.textContent = message;
                statusDiv.className = isError ? 'text-sm text-red-500 mt-2' : 'text-sm text-gray-500 mt-2';
            }
        }
        
        // Request camera permissions explicitly
        async function requestCameraPermission() {
            try {
                // Request camera permission explicitly
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: "environment" } 
                });
                // Stop the stream immediately, we just wanted permission
                stream.getTracks().forEach(track => track.stop());
                return true;
            } catch (err) {
                console.error('Camera permission error:', err);
                if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    updateStatus('Permisos de cámara denegados. Por favor, permite el acceso a la cámara en la configuración de tu navegador.', true);
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    updateStatus('No se encontró ninguna cámara. Verifica que tu dispositivo tenga una cámara conectada.', true);
                } else if (err.name === 'NotReadableError' || err.name === 'TrackStartError') {
                    updateStatus('La cámara está siendo usada por otra aplicación. Cierra otras aplicaciones que usen la cámara.', true);
                } else {
                    updateStatus('Error al acceder a la cámara: ' + (err.message || err.name || 'Error desconocido'), true);
                }
                return false;
            }
        }
        
        async function startScanner() {
            if (isScanning) return;
            
            if (typeof Html5Qrcode === 'undefined') {
                updateStatus('Error: La librería de escáner QR no se cargó correctamente.', true);
                return;
            }
            
            // First, request camera permission explicitly
            updateStatus('Solicitando permisos de cámara...');
            const hasPermission = await requestCameraPermission();
            
            if (!hasPermission) {
                return;
            }
            
            if (!html5QrCode) {
                try {
                    html5QrCode = new Html5Qrcode("qr-reader");
                } catch (err) {
                    updateStatus('Error al inicializar el escáner: ' + (err.message || 'Error desconocido'), true);
                    console.error('Error initializing scanner:', err);
                    return;
                }
            }
            
            updateStatus('Iniciando cámara...');
            
            // Try different camera configurations
            const configs = [
                { facingMode: "environment" },
                { facingMode: "user" }
            ];
            
            let configIndex = 0;
            
            function tryStart(config) {
                html5QrCode.start(
                    config,
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 },
                        aspectRatio: 1.0
                    },
                    onScanSuccess,
                    onScanFailure
                ).then(() => {
                    isScanning = true;
                    if (startBtn) startBtn.classList.add('hidden');
                    if (stopBtn) stopBtn.classList.remove('hidden');
                    updateStatus('Escáner activo. Apunta la cámara al código QR.');
                }).catch(err => {
                    console.error("Error starting QR scanner:", err);
                    
                    // Try next configuration
                    configIndex++;
                    if (configIndex < configs.length) {
                        updateStatus('Intentando otra configuración de cámara...');
                        tryStart(configs[configIndex]);
                    } else {
                        let errorMsg = 'No se pudo acceder a la cámara';
                        if (err.message) {
                            errorMsg = err.message;
                        } else if (err.name) {
                            errorMsg = err.name;
                        } else if (err.toString) {
                            errorMsg = err.toString();
                        }
                        
                        if (errorMsg.includes('not supported') || errorMsg.includes('NotSupportedError')) {
                            updateStatus('La cámara no está soportada en este navegador. Intenta con Chrome, Firefox o Edge. También asegúrate de usar HTTPS o localhost.', true);
                        } else {
                            updateStatus('Error al iniciar la cámara: ' + errorMsg + '. Verifica los permisos de cámara en la configuración de tu navegador.', true);
                        }
                        isScanning = false;
                    }
                });
            }
            
            tryStart(configs[0]);
        }
        
        function stopScanner() {
            if (!isScanning || !html5QrCode) return;
            
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
                isScanning = false;
                if (startBtn) startBtn.classList.remove('hidden');
                if (stopBtn) stopBtn.classList.add('hidden');
                updateStatus('Escáner detenido.');
            }).catch(err => {
                console.error("Error stopping scanner:", err);
                isScanning = false;
                if (startBtn) startBtn.classList.remove('hidden');
                if (stopBtn) stopBtn.classList.add('hidden');
                updateStatus('Escáner detenido.');
            });
        }
        
        function onScanSuccess(decodedText, decodedResult) {
            if (isScanning === false) return;
            
            updateStatus('Código escaneado: ' + decodedText);
            
            // Update the input field
            const input = document.querySelector('input[wire\\:model="scannedCode"]');
            if (input) {
                input.value = decodedText;
                // Trigger Livewire update
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            // Call the scanCoupon method
            const id = getComponentId();
            if (id && window.Livewire) {
                try {
                    const component = Livewire.find(id);
                    if (component) {
                        component.set('scannedCode', decodedText);
                        setTimeout(() => {
                            component.call('scanCoupon');
                        }, 100);
                    }
                } catch (err) {
                    console.error('Error calling Livewire method:', err);
                }
            }
            
            // Stop scanner after successful scan
            setTimeout(() => {
                stopScanner();
            }, 500);
        }

        function onScanFailure(error) {
            // Ignore scan errors - they're normal when no QR is in view
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
@endpush


