<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('📊 Panel de Estadísticas - Natural Go') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <form action="{{ route('reportes.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ $fecha_inicio }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="{{ $fecha_fin }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">
                            Filtrar Reporte
                        </button>
                        <a href="{{ route('reportes.pdf', request()->all()) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">
                            Descargar PDF
                        </a>
                        <a href="{{ route('reportes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md transition duration-150 text-center">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                    <p class="text-gray-500 font-semibold uppercase text-xs">Ingresos Totales (Rango)</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalIngresos, 2) }} Bs.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                    <p class="text-gray-500 font-semibold uppercase text-xs">Ventas Completadas</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalVentas }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                    <p class="text-gray-500 font-semibold uppercase text-xs">Productos en Catálogo</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalProductos }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-bold mb-4">Ventas por Día en el Periodo</h2>
                    <div style="height: 300px;">
                        <canvas id="chartVentas"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-bold mb-4">Top 5 Productos más Vendidos</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 px-2 text-xs font-semibold text-gray-600 uppercase">Producto</th>
                                <th class="py-2 px-2 text-xs font-semibold text-gray-600 uppercase text-right">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productosMasVendidos as $item)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-2 text-sm text-gray-700">{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                                <td class="py-3 px-2 text-sm font-bold text-right text-indigo-600">{{ (int)$item->total_cantidad }} uds</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-gray-500 italic">No hay ventas en este rango</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                <div class="flex items-center mb-4">
                    <span class="text-2xl mr-2">⚠️</span>
                    <h2 class="text-lg font-bold text-gray-800 uppercase tracking-wider">Alertas de Inventario Crítico (Detallado)</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b text-center">Código/ID</th>
                                <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b">Nombre del Producto</th>
                                <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b">Categoría</th>
                                <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b text-center">Stock Actual</th>
                                <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($productosStockBajo as $prod)
                            <tr class="hover:bg-red-50 transition">
                                <td class="py-3 px-4 text-sm text-gray-500 text-center">#{{ $prod->id }}</td>
                                <td class="py-3 px-4 text-sm text-gray-800 font-bold">{{ $prod->nombre }}</td>
                                <td class="py-3 px-4 text-sm text-gray-500">{{ $prod->categoria->nombre ?? 'N/A' }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-block px-3 py-1 text-sm font-bold {{ $prod->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }} rounded-full">
                                        {{ $prod->stock }} unidades
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('productos.show', $prod->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold underline">
                                        Ver Detalles
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-green-600 font-medium">
                                    <div class="flex flex-col items-center">
                                        <span class="text-3xl mb-2">✅</span>
                                        ¡Excelente! Todos los productos están abastecidos.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const etiquetas = JSON.parse('@json($ventasPorDia->pluck("fecha"))');
            const valores = JSON.parse('@json($ventasPorDia->pluck("total"))');

            const ctx = document.getElementById('chartVentas').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: etiquetas,
                    datasets: [{
                        label: 'Ventas (Bs)',
                        data: valores,
                        backgroundColor: 'rgba(79, 70, 229, 0.6)',
                        borderColor: 'rgb(79, 70, 229)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { callback: function(value) { return value + ' Bs'; } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
