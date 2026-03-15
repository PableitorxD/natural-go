<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario de Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                
                <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold text-gray-700">Productos en Almacén</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('inventarios.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            + Registrar Compra
                        </a>
                        <a href="{{ route('productos.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            + Nuevo Producto
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-left">
                        <thead class="bg-gray-50">
                            <tr class="text-xs uppercase text-gray-600 border-b">
                                <th class="p-4">Imagen</th>
                                <th class="p-4">Nombre</th>
                                <th class="p-4">Categoría</th>
                                <th class="p-4">P. Costo</th> 
                                <th class="p-4">P. Venta</th>
                                <th class="p-4">Ganancia Est.</th> 
                                <th class="p-4">Stock Real (Total)</th>
                                <th class="p-4 text-center">Acciones</th> 
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($productos as $producto)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 rounded-lg border border-dashed">Sin foto</div>
                                    @endif
                                </td>
                                <td class="p-4 font-bold text-gray-800">{{ $producto->nombre }}</td>
                                <td class="p-4 text-gray-600">{{ $producto->categoria->nombre }}</td>
                                
                                <td class="p-4 text-gray-500 italic">
                                    {{ number_format($producto->precio_costo, 2) }} Bs.
                                </td>

                                <td class="p-4 font-semibold text-blue-700">
                                    {{ number_format($producto->precio, 2) }} Bs.
                                </td>

                                <td class="p-4 text-green-600 font-bold">
                                    {{ number_format($producto->precio - $producto->precio_costo, 2) }} Bs.
                                </td>

                                <td class="p-4">
                                    {{-- AQUÍ USAMOS STOCK_REAL --}}
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $producto->stock_real < 5 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                        {{ $producto->stock_real }} unidades
                                    </span>
                                    <div class="text-[10px] text-gray-400 mt-1 italic">Suma de todos los almacenes</div>
                                </td>
                                
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('productos.edit', $producto) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold py-1 px-3 rounded uppercase tracking-wider transition">
                                            Editar
                                        </a>

                                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este producto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold py-1 px-3 rounded uppercase tracking-wider transition">
                                                Borrar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>