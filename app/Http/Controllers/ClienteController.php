<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // Importamos el modelo
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // 1. Mostrar la lista de clientes
    public function index()
    {
        $clientes = Cliente::all(); // Trae todos los clientes de la DB
        return view('clientes.index', compact('clientes')); // Va a una carpeta llamada 'clientes'
    }

    // 2. Mostrar el formulario para crear uno nuevo
    public function create()
    {
        return view('clientes.create');
    }

    // 3. Recibir los datos y guardarlos
    public function store(Request $request)
    {
        // Validamos que los datos sean correctos
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'ci' => 'required|unique:clientes',
        ]);

        // Creamos el cliente en la base de datos
        Cliente::create($request->all());

        // Redireccionamos a la lista con un mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'ci' => 'required|unique:clientes,ci,' . $cliente->id,
    ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado');
    }

    // 4. Mostrar el detalle de un cliente específico
    public function show(Cliente $cliente)
    {
        // Esto buscará el archivo en resources/views/clientes/show.blade.php
        return view('clientes.show', compact('cliente'));
    }
    
}