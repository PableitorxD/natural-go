<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Proveedores') }}
            </h2>
            <a href="{{ route('proveedores.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                + Nuevo Proveedor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-6 py-4 font-bold uppercase text-xs text-gray-600">Nombre / Empresa</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs text-gray-600">NIT</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs text-gray-600">Contacto</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs text-gray-600">Teléfono</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs text-gray-600 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($proveedores as $prov)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $prov->nombre }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $prov->nit ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $prov->contacto_nombre ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $prov->telefono ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('proveedores.edit', $prov) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-1 px-4 rounded uppercase shadow-sm transition">
                                            Editar
                                        </a>

                                        <form action="{{ route('proveedores.destroy', $prov) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-4 rounded uppercase shadow-sm transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                    No hay proveedores registrados todavía.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>