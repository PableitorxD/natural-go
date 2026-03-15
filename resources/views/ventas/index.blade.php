<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-700">Registro de Transacciones</h3>
                    <a href="{{ route('ventas.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md font-bold text-xs uppercase hover:bg-green-700 transition">
                        + Nueva Venta
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 shadow-sm border-l-4 border-green-500">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 shadow-sm border-l-4 border-red-500">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border text-left">
                        <thead class="bg-gray-50">
                            <tr class="text-sm text-gray-600 border-b">
                                <th class="p-3">Fecha</th>
                                <th class="p-3">Cliente</th>
                                <th class="p-3">Producto</th>
                                <th class="p-3">Método</th>
                                <th class="p-3">Total</th>
                                <th class="p-3 text-center">Estado</th>
                                <th class="p-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventas as $venta)
                            <tr class="border-b hover:bg-gray-50 transition {{ $venta->estado == 'anulado' ? 'bg-red-50' : '' }}">
                                <td class="p-3 text-sm italic">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-3 text-sm font-bold">{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                                <td class="p-3 text-sm">
                                    {{ $venta->producto->nombre ?? 'Eliminado' }}
                                    <span class="text-xs text-gray-400 block">Cant: {{ $venta->cantidad }}</span>
                                </td>
                                <td class="p-3 text-sm uppercase font-mono text-gray-500">
                                    {{ $venta->metodo_pago ?? 'N/E' }}
                                </td>
                                <td class="p-3 text-sm font-bold text-green-600">
                                    {{ number_format($venta->total, 2) }} Bs.
                                </td>
                                <td class="p-3 text-center">
                                    {{-- Ajuste visual del estado --}}
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                                        {{ $venta->estado == 'completado' ? 'bg-green-100 text-green-700' : 
                                           ($venta->estado == 'anulado' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ $venta->estado }}
                                    </span>
                                </td>
                                <td class="p-3 text-center flex justify-center items-center gap-3">
                                    {{-- Reintentar QR --}}
                                    @if($venta->estado == 'pendiente' && $venta->metodo_pago == 'qr')
                                        <a href="{{ route('pagos.qr', $venta->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs uppercase font-bold hover:bg-blue-700">
                                            Reintentar QR
                                        </a>
                                    @endif

                                    {{-- Ver Detalle --}}
                                    <a href="{{ route('ventas.show', $venta->id) }}" class="text-gray-500 hover:text-indigo-600 transition" title="Ver Detalle">
                                        👁️
                                    </a>

                                    {{-- Imprimir Ticket --}}
                                    <a href="{{ route('ventas.ticket', $venta->id) }}" target="_blank" class="text-gray-500 hover:text-green-600 transition" title="Imprimir Ticket">
                                        🖨️
                                    </a>

                                    {{-- Botón Anular --}}
                                    @if($venta->estado !== 'anulado')
                                        <form action="{{ route('ventas.anular', $venta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de anular esta venta? El stock será devuelto al almacén automáticamente.')" class="inline">
                                            @csrf
                                            <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors duration-200 transform hover:scale-125" title="Anular Venta">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="p-8 text-center text-gray-500">No hay ventas registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>