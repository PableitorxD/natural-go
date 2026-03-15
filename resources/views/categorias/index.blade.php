<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorías de Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-bold mb-4">Nueva Categoría</h3>
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <x-primary-button>Guardar</x-primary-button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white p-6 shadow-sm sm:rounded-lg">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="text-left py-2 border-b">Nombre</th>
                            <th class="text-left py-2 border-b">Descripción</th>
                            <th class="text-left py-2 border-b">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $cat)
                        <tr>
                            <td class="py-2 border-b">{{ $cat->nombre }}</td>
                            <td class="py-2 border-b text-gray-500">{{ $cat->descripcion }}</td>
                            <td class="py-2 border-b">
                                <form action="{{ route('categorias.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
        @csrf 
        @method('DELETE')
        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 transition ease-in-out duration-150">
            Eliminar
        </button>
    </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>