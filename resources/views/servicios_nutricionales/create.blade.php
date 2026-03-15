<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Evaluación Nutricional') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border-t-4 border-blue-500">
                <form action="{{ route('servicios-nutricionales.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Cliente</label>
                            <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="" disabled {{ !isset($cliente_id_seleccionado) ? 'selected' : '' }}>Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" 
                                        {{ (isset($cliente_id_seleccionado) && $cliente_id_seleccionado == $cliente->id) ? 'selected' : '' }}>
                                        {{ $cliente->nombre }} {{ $cliente->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Fecha de Consulta</label>
                            <input type="date" name="fecha_consulta" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" required>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-blue-700 mb-4 border-b">Datos Antropométricos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 italic">Peso (kg)</label>
                            <input type="number" step="0.01" name="peso" placeholder="70.5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 italic">Talla (m)</label>
                            <input type="number" step="0.01" name="talla" placeholder="1.70" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 italic">% Grasa</label>
                            <input type="number" step="0.1" name="porcentaje_grasa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 italic">% Músculo</label>
                            <input type="number" step="0.1" name="porcentaje_musculo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-blue-700 mb-4 border-b">Plan y Observaciones</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Objetivo del Cliente</label>
                            <textarea name="objetivo" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" placeholder="Ej: Aumentar masa muscular..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Plan Alimenticio / Sugerencias</label>
                            <textarea name="plan_sugerido" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500" placeholder="Detalle de la dieta o suplementos recomendados..."></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('servicios-nutricionales.index') }}" class="text-gray-600 hover:text-gray-900 underline py-2 transition">Cancelar</a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                            {{ __('Guardar Evaluación') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>