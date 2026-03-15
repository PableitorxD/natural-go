<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraspasoController extends Controller
{
    public function create()
    {
        $almacenes = Almacen::all();
        // Solo enviamos productos que tengan stock global para traspasar
        $productos = Producto::where('stock', '>', 0)->get();
        return view('inventarios.traspaso', compact('almacenes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'origen_id' => 'required|exists:almacenes,id',
            'destino_id' => 'required|exists:almacenes,id|different:origen_id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // 1. Obtener información de los almacenes para el historial
        $almacenOrigen = Almacen::findOrFail($request->origen_id);
        $almacenDestino = Almacen::findOrFail($request->destino_id);

        // 2. Verificar si hay stock suficiente específicamente en la sucursal de origen
        $stockOrigen = Inventario::where('almacen_id', $request->origen_id)
            ->where('producto_id', $request->producto_id)
            ->sum('cantidad');

        if ($stockOrigen < $request->cantidad) {
            return back()->with('error', "La sucursal {$almacenOrigen->nombre} solo tiene {$stockOrigen} unidades disponibles.");
        }

        // 3. Ejecutar el traspaso en una transacción para asegurar que se hagan ambos movimientos
        DB::transaction(function () use ($request, $almacenOrigen, $almacenDestino) {
            
            // Movimiento de SALIDA del origen
            Inventario::create([
                'producto_id' => $request->producto_id,
                'almacen_id' => $request->origen_id,
                'cantidad' => -$request->cantidad,
                'proveedor' => "TRASPASO: Envío a " . $almacenDestino->nombre,
            ]);

            // Movimiento de ENTRADA al destino
            Inventario::create([
                'producto_id' => $request->producto_id,
                'almacen_id' => $request->destino_id,
                'cantidad' => $request->cantidad,
                'proveedor' => "TRASPASO: Recibido de " . $almacenOrigen->nombre,
            ]);
        });

        return redirect()->route('inventarios.index')->with('success', 'Traspaso realizado con éxito y reflejado en el historial.');
    }
}