<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Nombre del Producto</label>
                            <input type="text" name="nombre" class="w-full border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Categoría</label>
                            <select name="categoria_id" class="w-full border-gray-300 rounded-md" required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Precio de Costo (Bs.)</label>
                            <input type="number" step="0.01" name="precio_costo" class="w-full border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Precio de Venta (Bs.)</label>
                            <input type="number" step="0.01" name="precio" class="w-full border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Stock Inicial</label>
                            <input type="number" name="stock" class="w-full border-gray-300 rounded-md" required min="0">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-blue-600 font-bold">Ubicación (Almacén)</label>
                            <select name="almacen_id" class="w-full border-blue-300 rounded-md bg-blue-50" required>
                                <option value="">¿A qué almacén entra?</option>
                                @foreach($almacenes as $alm)
                                    <option value="{{ $alm->id }}">{{ $alm->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Foto del Producto</label>
                        <input type="file" name="imagen" class="w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('productos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow">Cancelar</a>
                        <x-primary-button>Guardar Producto</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>