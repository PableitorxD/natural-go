<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Almacen;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['cliente', 'producto', 'almacen'])->latest()->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $almacenes = Almacen::all();
        $productos = Producto::all(); // Quitamos el filtro de stock aquí para que el controlador valide
        return view('ventas.create', compact('clientes', 'productos', 'almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'cantidad' => 'required|integer|min:1',
            'metodo_pago' => 'required|in:efectivo,qr,tarjeta', // Nueva validación
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($producto->stock_real < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock en los almacenes.');
        }

        $total = $producto->precio * $request->cantidad;
        
        // Si es QR, la venta nace "pendiente", si es otro, "completado"
        $estadoInicial = ($request->metodo_pago === 'qr') ? 'pendiente' : 'completado';

        return DB::transaction(function () use ($request, $producto, $total, $estadoInicial) {
            
            // 1. Registrar la venta
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'producto_id' => $request->producto_id,
                'almacen_id' => $request->almacen_id,
                'cantidad' => $request->cantidad,
                'total' => $total,
                'estado' => $estadoInicial,
                'metodo_pago' => $request->metodo_pago // Asegúrate de tener esta columna
            ]);

            // 2. Registrar salida de inventario (Descontamos siempre, si el QR expira, se debería revertir)
            Inventario::create([
                'producto_id' => $request->producto_id,
                'almacen_id'  => $request->almacen_id,
                'cantidad'    => -$request->cantidad, 
                'proveedor'   => 'Venta Nro: ' . $venta->id . ' (' . ucfirst($request->metodo_pago) . ')',
            ]);

            // 3. DECISIÓN DE REDIRECCIÓN
            if ($request->metodo_pago === 'qr') {
                return redirect()->route('pagos.qr', $venta->id);
            }

            return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito en ' . $request->metodo_pago);
        });
    }

    public function generarTicket(Venta $venta)
    {
        // Cargamos la relación para que el PDF tenga nombre de cliente y producto
        $venta->load(['cliente', 'producto', 'almacen']);

        // Cargamos una vista que crearemos ahora
        $pdf = Pdf::loadView('ventas.ticket', compact('venta'))
                ->setPaper([0, 0, 226.77, 500], 'portrait'); // Tamaño térmico (80mm)

        return $pdf->stream('ticket-venta-' . $venta->id . '.pdf');
    }

    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'producto', 'almacen']);
        return view('ventas.show', compact('venta'));
    }

    public function anular(Venta $venta)
    {
        if ($venta->estado === 'anulado') {
            return back()->with('error', 'Esta venta ya ha sido anulada.');
        }

        try {
            DB::transaction(function () use ($venta) {
                // 1. Devolver el Stock al Inventario
                // Buscamos el registro de inventario que coincida con el producto y el almacén de la venta
                $inventario = \App\Models\Inventario::where('producto_id', $venta->producto_id)
                    ->where('almacen_id', $venta->almacen_id)
                    ->first();

                if ($inventario) {
                    $inventario->increment('cantidad', $venta->cantidad);
                }

                // 2. Cambiar el estado de la venta
                $venta->update([
                    'estado' => 'anulado'
                ]);
            });

            return back()->with('success', 'Venta anulada correctamente. El stock ha sido devuelto.');

        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un problema al anular la venta: ' . $e->getMessage());
        }
    }

    
}