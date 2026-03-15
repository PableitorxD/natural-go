<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Muestra la lista de proveedores.
     */
    public function index()
    {
        $proveedores = Proveedor::latest()->get();
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Almacena un proveedor recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nit' => 'nullable|string|max:20|unique:proveedores,nit',
            'telefono' => 'nullable|string|max:20',
            'contacto_nombre' => 'nullable|string|max:255',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor registrado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un proveedor.
     */
    public function edit(Proveedor $proveedore)
    {
        // Nota: Laravel por la ruta resource podría llamar al parámetro 'proveedore'
        // pero gracias a nuestra corrección en el Modelo, funcionará bien.
        return view('proveedores.edit', ['proveedor' => $proveedore]);
    }

    /**
     * Actualiza el proveedor en la base de datos.
     */
    public function update(Request $request, Proveedor $proveedore)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nit' => 'nullable|string|max:20|unique:proveedores,nit,' . $proveedore->id,
        ]);

        $proveedore->update($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', 'Información del proveedor actualizada.');
    }

    /**
     * Elimina un proveedor.
     */
    public function destroy(Proveedor $proveedore)
    {
        $proveedore->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}