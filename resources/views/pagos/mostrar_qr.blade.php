<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cobro con QR - Libélula') }}
            </h2>
            <a href="{{ route('ventas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded text-xs uppercase font-bold">
                Volver a Ventas
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 border-t-4 border-blue-600">
                
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-black text-gray-800">Natural Go</h3>
                    <p class="text-sm text-gray-500 uppercase tracking-widest">Orden de Pago #{{ $venta->id }}</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-200 flex justify-center items-center mb-6">
                    @if($qr)
                        @if(Str::startsWith($qr, 'http'))
                            <img src="{{ $qr }}" alt="Código QR de Pago" class="w-64 h-64 shadow-md">
                        @else
                            <img src="{{ Str::contains($qr, 'data:image') ? $qr : 'data:image/png;base64,' . $qr }}" 
                                 alt="Código QR de Pago" class="w-64 h-64 shadow-md">
                        @endif
                    @elseif(isset($url_pasarela))
                        <div class="text-center p-4">
                            <p class="text-gray-600 mb-4 font-semibold">Ya existe un cobro activo para esta venta.</p>
                            <a href="{{ $url_pasarela }}" target="_blank" 
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200">
                                Pagar en Pasarela Libélula
                            </a>
                            <p class="text-[10px] text-gray-400 mt-4">Podrás pagar con QR o Tarjeta desde el link oficial.</p>
                        </div>
                    @else
                        <div class="text-center text-red-500 p-4">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <p class="font-bold">No se pudo generar el QR</p>
                            <p class="text-xs">Por favor, contacte con soporte o intente más tarde.</p>
                        </div>
                    @endif
                </div>

                <div class="space-y-3 mb-8">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Cliente:</span>
                        <span class="font-bold text-gray-800">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 text-lg">Total a pagar:</span>
                        <span class="text-2xl font-black text-blue-700">{{ number_format($venta->total, 2) }} Bs.</span>
                    </div>
                </div>

                @if($qr || isset($url_pasarela))
                    <div id="status-container" class="flex items-center justify-center space-x-2 text-blue-600 bg-blue-50 p-3 rounded-lg animate-pulse">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-bold uppercase tracking-tight">Esperando confirmación...</span>
                    </div>
                @endif

                <p class="mt-6 text-[10px] text-center text-gray-400">
                    Este código QR es válido por tiempo limitado. Una vez realizado el pago, el sistema se actualizará automáticamente.
                </p>
            </div>
        </div>
    </div>

    {{-- SCRIPT DE VERIFICACIÓN AUTOMÁTICA --}}
        <script>
            const checkStatus = setInterval(() => {
                // Usamos una ruta relativa para que no haya problemas de dominios (Ngrok vs Localhost)
                fetch("/verificar-pago/{{ $venta->id }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en servidor');
                    return response.json();
                })
                .then(data => {
                    console.log("Estado: ", data.estado);
                    if (data.estado === 'completado' || data.estado === 'pagado') {
                        clearInterval(checkStatus);
                        // Usamos una ruta relativa también para la redirección
                        window.location.href = "/ventas"; 
                    }
                })
                .catch(error => {
                    console.error('Error en la verificación:', error);
                });
            }, 3000);
        </script>
</x-app-layout>