<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Compra / Entrada de Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-500">
                <div class="p-6 text-gray-900">
                    <p class="mb-6 text-sm text-gray-600">
                        Use este formulario para registrar compras. Esto actualizará el stock en la sucursal y el costo base del producto.
                    </p>

                    <form action="{{ route('inventarios.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="producto_id" class="block text-sm font-bold text-gray-700">Producto</label>
                                <select name="producto_id" id="producto_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="" disabled selected>Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }} (Actual: {{ $producto->precio_costo }} Bs)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="almacen_id" class="block text-sm font-bold text-gray-700">Sucursal (Destino)</label>
                                <select name="almacen_id" id="almacen_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="" disabled selected>¿A qué almacén ingresa?</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="cantidad" class="block text-sm font-bold text-gray-700">Cantidad Comprada</label>
                                <input type="number" name="cantidad" id="cantidad" min="1" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    placeholder="Ej: 50" required>
                            </div>

                            <div>
                                <label for="proveedor" class="block text-sm font-bold text-gray-700">Proveedor Oficial</label>
                                <select name="proveedor" id="proveedor" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="" disabled selected>Seleccione el proveedor</option>
                                    @foreach($proveedores as $prov)
                                        <option value="{{ $prov->nombre }}">{{ $prov->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="precio_costo" class="block text-sm font-bold text-gray-700">Precio de Costo Unitario (Bs)</label>
                                <input type="number" step="0.01" name="precio_costo" id="precio_costo" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                    placeholder="Ej: 45.00" required>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end gap-4 border-t pt-6">
                            <a href="{{ route('inventarios.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Cancelar
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 shadow-lg">
                                {{ __('Cargar Compra e Inventario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>