<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resumen del Negocio') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-blue-500">
                    <div class="text-sm font-bold text-blue-500 uppercase">Ventas Totales</div>
                    <div class="text-2xl font-black text-gray-800">{{ number_format($totalVentas, 2) }} Bs.</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-green-500">
                    <div class="text-sm font-bold text-green-500 uppercase">Ventas de Hoy</div>
                    <div class="text-2xl font-black text-gray-800">{{ $ventasHoy }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-purple-500">
                    <div class="text-sm font-bold text-purple-500 uppercase">Productos</div>
                    <div class="text-2xl font-black text-gray-800">{{ $productosCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-orange-500">
                    <div class="text-sm font-bold text-orange-500 uppercase">Sucursales</div>
                    <div class="text-2xl font-black text-gray-800">{{ $almacenesCount }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-red-600 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Alertas de Stock Crítico
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="p-2">Producto</th>
                                    <th class="p-2 text-center">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockBajo as $prod)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2 font-medium text-gray-700">{{ $prod->nombre }}</td>
                                    <td class="p-2 text-center">
                                        <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 font-bold text-xs">
                                            {{ $prod->stock }} un.
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-gray-400 italic">No hay productos agotándose ✅</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Últimas Ventas Realizadas</h3>
                    <div class="space-y-4">
                        @foreach($ultimasVentas as $v)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <p class="font-bold text-gray-800 text-sm">{{ $v->producto->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $v->cliente->nombre }} | {{ $v->almacen->nombre }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-gray-800">{{ number_format($v->total, 2) }} Bs.</p>
                                <p class="text-[10px] text-gray-400 uppercase">{{ $v->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>