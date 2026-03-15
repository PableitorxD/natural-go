<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('ventas.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select name="cliente_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sucursal de Salida (Stock Local)</label>
                            <select name="almacen_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">¿De qué sucursal sale el producto?</option>
                                @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Producto</label>
                            <select name="producto_id" id="producto_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required onchange="actualizarPrecio()">
                                <option value="">Seleccione un producto</option>
                                @foreach($productos as $producto)
                                    {{-- Usamos stock_real que es el que calculamos en el modelo --}}
                                    <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock_real }}">
                                        {{ $producto->nombre }} (Disponible: {{ $producto->stock_real }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad a Vender</label>
                            <input type="number" name="cantidad" id="cantidad" min="1" value="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required oninput="actualizarTotal()">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                            <div class="grid grid-cols-3 gap-4">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="metodo_pago" value="efectivo" class="text-indigo-600" checked>
                                    <span class="ml-2 text-sm">💵 Efectivo</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="metodo_pago" value="qr" class="text-indigo-600">
                                    <span class="ml-2 text-sm">📱 QR Libélula</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="metodo_pago" value="tarjeta" class="text-indigo-600">
                                    <span class="ml-2 text-sm">💳 Tarjeta</span>
                                </label>
                            </div>
                        </div>

                        <div class="md:col-span-2 bg-indigo-50 p-4 rounded-md border border-indigo-100">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-indigo-600 font-medium">Precio Unitario: <span id="precio_unitario">0.00</span> Bs.</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 uppercase tracking-wider">Total Final</p>
                                    <p class="text-2xl font-black text-indigo-700"><span id="precio_total">0.00</span> Bs.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end items-center border-t pt-6">
                        <a href="{{ route('ventas.index') }}" class="text-gray-500 px-4 py-2 mr-4 hover:text-gray-700 transition">Regresar</a>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 shadow-lg">
                            {{ __('Procesar Venta') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function actualizarPrecio() {
            const select = document.getElementById('producto_id');
            const selectedOption = select.options[select.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio') || 0;
            
            document.getElementById('precio_unitario').innerText = parseFloat(precio).toFixed(2);
            actualizarTotal();
        }

        function actualizarTotal() {
            const precio = parseFloat(document.getElementById('precio_unitario').innerText);
            const cantidad = parseInt(document.getElementById('cantidad').value) || 0;
            const total = precio * cantidad;
            
            document.getElementById('precio_total').innerText = total.toFixed(2);
        }
    </script>
</x-app-layout>