<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ficha Nutricional de ') }} {{ $consulta->cliente->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden border">
                <div class="bg-gray-800 p-6 text-white flex justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-widest text-gray-400">Fecha de Consulta</p>
                        <h3 class="text-xl font-bold">{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d \d\e F, Y') }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-sm uppercase tracking-widest text-gray-400">Estado IMC</p>
                        <h3 class="text-xl font-bold">{{ $consulta->imc }} ({{ $consulta->imc > 25 ? 'Sobrepeso' : 'Saludable' }})</h3>
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-bold text-blue-600 border-b mb-4">Composición Corporal</h4>
                        <ul class="space-y-3">
                            <li class="flex justify-between"><span>Peso:</span> <strong>{{ $consulta->peso }} kg</strong></li>
                            <li class="flex justify-between"><span>Talla:</span> <strong>{{ $consulta->talla }} m</strong></li>
                            <li class="flex justify-between"><span>Grasa Corporal:</span> <strong>{{ $consulta->porcentaje_grasa ?? 'N/A' }} %</strong></li>
                            <li class="flex justify-between"><span>Músculo:</span> <strong>{{ $consulta->porcentaje_musculo ?? 'N/A' }} %</strong></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-600 border-b mb-4">Resumen del Plan</h4>
                        <p class="text-sm text-gray-700 font-bold">Objetivo:</p>
                        <p class="text-sm text-gray-600 mb-4">{{ $consulta->objetivo }}</p>
                        
                        <p class="text-sm text-gray-700 font-bold">Recomendación:</p>
                        <p class="text-sm text-gray-600 italic">{{ $consulta->plan_sugerido }}</p>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 text-center border-t">
                    <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-700">
                        🖨️ Imprimir Ficha
                    </button>
                    <a href="{{ route('servicios-nutricionales.index') }}" class="ml-4 text-sm text-blue-600 font-bold">Volver al historial</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>