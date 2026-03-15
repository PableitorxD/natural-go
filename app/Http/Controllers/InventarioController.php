<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with(['producto', 'almacen'])
                        ->latest()
                        ->paginate(10);

        return view('inventarios.index', compact('inventarios'));
    }

    public function create()
    {
        $productos = Producto::all();
        $almacenes = Almacen::all(); 
        $proveedores = Proveedor::all(); // Usamos el modelo importado
        return view('inventarios.create', compact('productos', 'almacenes', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id'  => 'required|exists:productos,id',
            'almacen_id'   => 'required|exists:almacenes,id',
            'cantidad'     => 'required|integer|min:1',
            'proveedor'    => 'required|string',
            'precio_costo' => 'required|numeric|min:0', 
        ]);

        DB::transaction(function () use ($request) {
            // 1. Crear el movimiento de inventario
            Inventario::create([
                'producto_id' => $request->producto_id,
                'almacen_id'  => $request->almacen_id,
                'cantidad'    => $request->cantidad,
                'proveedor'   => "COMPRA: " . $request->proveedor,
            ]);

            // 2. Actualizar el precio de costo en el producto
            $producto = Producto::find($request->producto_id);
            $producto->precio_costo = $request->precio_costo;
            $producto->save();
        });

        return redirect()->route('inventarios.index')->with('success', 'Compra registrada y costo de producto actualizado.');
    }
}