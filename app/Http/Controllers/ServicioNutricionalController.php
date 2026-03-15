<?php

namespace App\Http\Controllers;

use App\Models\ServicioNutricional;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ServicioNutricionalController extends Controller
{
    // Ver historial de consultas
    public function index()
    {
        $consultas = ServicioNutricional::with('cliente')->latest()->paginate(10);
        return view('servicios_nutricionales.index', compact('consultas'));
    }

    // Formulario para nueva consulta
    public function create(Request $request)
    {
        $clientes = \App\Models\Cliente::all();
        
        // Capturamos el cliente_id si viene en la URL
        $cliente_id_seleccionado = $request->get('cliente_id'); 

        return view('servicios_nutricionales.create', compact('clientes', 'cliente_id_seleccionado'));
    }

    // Guardar la consulta
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_consulta' => 'required|date',
            'peso' => 'required|numeric|min:1',
            'talla' => 'required|numeric|min:0.5',
            'porcentaje_grasa' => 'nullable|numeric',
            'porcentaje_musculo' => 'nullable|numeric',
        ]);

        // Calcular IMC automáticamente: Peso / (Talla * Talla)
        $imc = $request->peso / ($request->talla * $request->talla);

        ServicioNutricional::create([
            'cliente_id' => $request->cliente_id,
            'fecha_consulta' => $request->fecha_consulta,
            'peso' => $request->peso,
            'talla' => $request->talla,
            'imc' => round($imc, 2), // Guardamos con 2 decimales
            'porcentaje_grasa' => $request->porcentaje_grasa,
            'porcentaje_musculo' => $request->porcentaje_musculo,
            'cintura' => $request->cintura,
            'cadera' => $request->cadera,
            'objetivo' => $request->objetivo,
            'plan_sugerido' => $request->plan_sugerido,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('servicios-nutricionales.index')
                         ->with('success', 'Evaluación nutricional registrada correctamente.');
    }

    // Ver detalle de una consulta específica
    public function show(ServicioNutricional $servicios_nutricionale)
    {
        // Nota: Laravel usa el nombre en singular del recurso, por eso la variable es así
        return view('servicios_nutricionales.show', ['consulta' => $servicios_nutricionale]);
    }
}