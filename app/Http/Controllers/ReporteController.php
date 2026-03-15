<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // 1. Capturamos las fechas del formulario o fijamos por defecto (últimos 30 días)
        $fecha_inicio = $request->get('fecha_inicio', now()->subDays(30)->format('Y-m-d'));
        $fecha_fin = $request->get('fecha_fin', now()->format('Y-m-d'));

        // Ajustamos la fecha fin para que incluya todo el día
        $fecha_fin_ajustada = $fecha_fin . ' 23:59:59';

        // 2. KPIs filtrados por rango
        $totalIngresos = Venta::where('estado', 'completado')
            ->whereBetween('created_at', [$fecha_inicio, $fecha_fin_ajustada])
            ->sum('total');

        $totalVentas = Venta::where('estado', 'completado')
            ->whereBetween('created_at', [$fecha_inicio, $fecha_fin_ajustada])
            ->count();

        $totalProductos = Producto::count();

        // 3. Datos para el gráfico
        $ventasPorDia = Venta::where('estado', 'completado')
            ->select(DB::raw('DATE(created_at) as fecha'), DB::raw('SUM(total) as total'))
            ->whereBetween('created_at', [$fecha_inicio, $fecha_fin_ajustada])
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        // 4. Top 5 Productos más vendidos en el rango
        $productosMasVendidos = Venta::select('producto_id', DB::raw('SUM(cantidad) as total_cantidad'))
            ->where('estado', 'completado')
            ->whereBetween('created_at', [$fecha_inicio, $fecha_fin_ajustada])
            ->groupBy('producto_id')
            ->with('producto')
            ->orderByDesc('total_cantidad')
            ->take(5)
            ->get();

        // 5. Stock Crítico
        $productosStockBajo = Producto::where('stock', '<=', 5)
            ->with('categoria')
            ->orderBy('stock', 'asc')
            ->get();

        return view('reportes.index', compact(
            'totalIngresos',
            'totalVentas',
            'totalProductos',
            'ventasPorDia',
            'productosMasVendidos',
            'fecha_inicio',
            'fecha_fin',
            'productosStockBajo'
        ));
    }

    public function generarPdf(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicio', now()->subDays(30)->format('Y-m-d'));
        $fecha_fin = $request->get('fecha_fin', now()->format('Y-m-d'));
        $fecha_fin_ajustada = $fecha_fin . ' 23:59:59';

        $totalIngresos = Venta::where('estado', 'completado')
            ->whereBetween('created_at', [$fecha_inicio, $fecha_fin_ajustada])->sum('total');

        $ventas = Venta::where('estado', 'completado')
            ->whereBetween('created_at', [$fecha_inicio, $fecha_fin_ajustada])
            ->with('cliente') // Cargamos la relación del cliente
            ->get();

        $productosStockBajo = Producto::where('stock', '<=', 5)->get();

        // Usamos directamente Pdf::loadView gracias al import superior
        $pdf = Pdf::loadView('reportes.pdf', compact(
            'totalIngresos', 'ventas', 'fecha_inicio', 'fecha_fin', 'productosStockBajo'
        ));

        return $pdf->download('reporte-ventas-natural-go.pdf');
    }
}
