<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // IMPORTANTE: Esto quita el error de 'DB'

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::all();
        return view('almacenes.index', compact('almacenes'));
    }

    public function show($id) // Cambiamos el Typehint por $id para asegurar la captura
    {
        // Buscamos el almacen manualmente para evitar errores de inyección
        $almacen = Almacen::findOrFail($id);

        // Ejecutamos la consulta usando el ID verificado
        $stock_por_producto = Inventario::where('almacen_id', $almacen->id)
            ->select('producto_id', DB::raw('SUM(cantidad) as total_stock'))
            ->groupBy('producto_id')
            ->with(['producto.categoria'])
            ->get();

        return view('almacenes.show', compact('almacen', 'stock_por_producto'));
    }

    // Los métodos create, store, edit, update, destroy los puedes completar 
    // si necesitas añadir o borrar sucursales manualmente.
}