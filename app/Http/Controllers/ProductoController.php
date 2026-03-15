<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Almacen;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        // Cargamos categoria e inventarios para evitar el problema N+1
        $productos = Producto::with(['categoria', 'inventarios'])->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $almacenes = Almacen::all(); // Necesitamos los almacenes para el stock inicial
        return view('productos.create', compact('categorias', 'almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio'       => 'required|numeric',
            'stock'        => 'required|integer|min:0',
            'almacen_id'   => 'required|exists:almacenes,id', // Validamos el almacén
            'categoria_id' => 'required|exists:categorias,id',
            'imagen'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $data = $request->all();

                if ($request->hasFile('imagen')) {
                    $data['imagen'] = $request->file('imagen')->store('productos', 'public');
                }

                // 1. Crear el producto
                $producto = Producto::create($data);

                // 2. Crear el registro de inventario inicial para que el stock no sea "fantasma"
                Inventario::create([
                    'producto_id' => $producto->id,
                    'almacen_id'  => $request->almacen_id,
                    'cantidad'    => $request->stock,
                    'proveedor'   => 'Stock Inicial',
                ]);

                return redirect()->route('productos.index')->with('success', 'Producto e inventario inicial creados correctamente');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear: ' . $e->getMessage());
        }
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'       => 'required',
            'precio'       => 'required|numeric',
            'stock'        => 'required|integer', // Nota: Actualizar stock aquí solo cambia el número estático del producto
            'categoria_id' => 'required|exists:categorias,id',
            'imagen'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($producto) {
                // 1. Borramos los registros de inventario asociados
                $producto->inventarios()->delete();

                // 2. Borramos la imagen del servidor si existe
                if ($producto->imagen) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($producto->imagen);
                }

                // 3. Borramos el producto
                $producto->delete();

                return redirect()->route('productos.index')->with('success', 'Producto e historial de inventario eliminados con éxito');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar el producto: ' . $e->getMessage());
        }
    }

    public function show(Producto $producto)
    {
        return redirect()->route('productos.index');
    }
}