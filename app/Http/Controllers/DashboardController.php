<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Almacen;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Estadísticas rápidas
        $totalVentas = Venta::sum('total');
        $ventasHoy = Venta::whereDate('created_at', today())->count();
        $productosCount = Producto::count();
        $almacenesCount = Almacen::count();
        
        // 2. Alerta de Stock Bajo (menos de 5 unidades)
        $stockBajo = Producto::where('stock', '<=', 5)
                            ->orderBy('stock', 'asc')
                            ->get();

        // 3. Últimos movimientos de ventas
        $ultimasVentas = Venta::with(['cliente', 'producto', 'almacen'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('dashboard', compact(
            'totalVentas', 
            'ventasHoy', 
            'productosCount', 
            'almacenesCount',
            'stockBajo', 
            'ultimasVentas'
        ));
    }
}