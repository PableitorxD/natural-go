<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfil del Cliente: {{ $cliente->nombre }} {{ $cliente->apellido }}
            </h2>
            <a href="{{ route('clientes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded text-xs">Volver</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4 border-b">Información Personal</h3>
                <p><strong>CI:</strong> {{ $cliente->ci }}</p>
                <p><strong>Nombre:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                </div>

            <div class="p-6 bg-white shadow-md rounded-lg border-t-4 border-blue-500">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Servicio Nutricional</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('servicios-nutricionales.create', ['cliente_id' => $cliente->id]) }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-md text-xs uppercase font-bold tracking-widest hover:bg-blue-700">
                        + Nueva Evaluación Nutricional
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>