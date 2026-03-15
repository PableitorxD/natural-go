<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Producto: {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Nombre</label>
                            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="w-full border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Categoría</label>
                            <select name="categoria_id" class="w-full border-gray-300 rounded-md" required>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Precio (Bs.)</label>
                            <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}" class="w-full border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Stock</label>
                            <input type="number" name="stock" value="{{ $producto->stock }}" class="w-full border-gray-300 rounded-md" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Actualizar Foto (dejar vacío para mantener la actual)</label>
                        <input type="file" name="imagen" class="w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Actualizar Cambios</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>