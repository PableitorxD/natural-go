<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Historial de Consultas Nutricionales') }}
            </h2>
            <a href="{{ route('servicios-nutricionales.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                + Nueva Evaluación
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-bold uppercase text-gray-600 border-b">
                                <th class="p-4">Fecha</th>
                                <th class="p-4">Cliente</th>
                                <th class="p-4">Peso (kg)</th>
                                <th class="p-4">IMC</th>
                                <th class="p-4">Objetivo</th>
                                <th class="p-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($consultas as $consulta)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y') }}
                                </td>
                                <td class="p-4 font-bold text-gray-800">
                                    {{ $consulta->cliente->nombre }} {{ $consulta->cliente->apellido }}
                                </td>
                                <td class="p-4 text-sm">{{ $consulta->peso }} kg</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-white text-xs font-bold {{ $consulta->imc > 25 ? 'bg-orange-500' : 'bg-green-500' }}">
                                        {{ $consulta->imc }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600 italic text-sm">
                                    {{ Str::limit($consulta->objetivo, 30) }}
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('servicios-nutricionales.show', $consulta) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150 shadow-sm">
                                        Ver Ficha
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $consultas->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>