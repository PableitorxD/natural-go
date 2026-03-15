<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Venta #{{ $venta->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-lg rounded-lg border-t-4 border-indigo-500">
                <div class="flex justify-between border-b pb-4 mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 uppercase">Resumen de Transacción</h3>
                        <p class="text-sm text-gray-500">Registrado el {{ $venta->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="px-4 py-2 rounded-full text-xs font-bold uppercase {{ $venta->estado == 'completado' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $venta->estado }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="font-bold text-indigo-700 mb-2 border-b">Información del Cliente</h4>
                        <p><b>Nombre:</b> {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</p>
                        <p><b>CI/NIT:</b> {{ $venta->cliente->ci ?? 'No registrado' }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="font-bold text-indigo-700 mb-2 border-b">Detalles del Pago</h4>
                        <p><b>Método:</b> <span class="uppercase font-mono">{{ $venta->metodo_pago }}</span></p>
                        <p><b>Sucursal:</b> {{ $venta->almacen->nombre }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-indigo-600 text-white">
                                <th class="p-3">Producto</th>
                                <th class="p-3 text-center">Cantidad</th>
                                <th class="p-3 text-right">Precio Unit.</th>
                                <th class="p-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">{{ $venta->producto->nombre }}</td>
                                <td class="p-3 text-center">{{ $venta->cantidad }}</td>
                                <td class="p-3 text-right">{{ number_format($venta->producto->precio, 2) }} Bs.</td>
                                <td class="p-3 text-right font-bold">{{ number_format($venta->total, 2) }} Bs.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('ventas.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition">
                        Volver al Historial
                    </a>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm">Total Pagado:</p>
                        <p class="text-3xl font-black text-indigo-700">{{ number_format($venta->total, 2) }} Bs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>