<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sucursales (Almacenes)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg overflow-hidden">
                
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-700">Gestión de Sucursales</h3>
                </div>

                <table class="min-w-full border text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-3 border-b">Nombre de Sucursal</th>
                            <th class="p-3 border-b">Dirección / Ubicación</th>
                            <th class="p-3 border-b text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($almacenes as $almacen)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3 font-bold text-gray-800">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m4 0h1m-5 10h1m4 0h1m-5-4h1m4 0h1"></path>
                                    </svg>
                                    {{ $almacen->nombre }}
                                </span>
                            </td>
                            <td class="p-3 text-gray-600">{{ $almacen->ubicacion }}</td>
                            <td class="p-3 text-center">
                                <a href="{{ route('almacenes.show', $almacen) }}" class="inline-flex items-center px-4 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 transition ease-in-out duration-150 shadow-sm">
                                     Ver Stock
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>