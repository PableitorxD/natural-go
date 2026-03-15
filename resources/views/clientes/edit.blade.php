<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Cliente</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label>Nombre</label>
                            <input type="text" name="nombre" value="{{ $cliente->nombre }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label>Apellido</label>
                            <input type="text" name="apellido" value="{{ $cliente->apellido }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label>CI</label>
                            <input type="text" name="ci" value="{{ $cliente->ci }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label>Teléfono</label>
                            <input type="text" name="telefono" value="{{ $cliente->telefono }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Actualizar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>