<?php

use App\Models\Venta;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\TraspasoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ServicioNutricionalController;
use App\Http\Controllers\LibelulaController;
use App\Http\Controllers\ReporteController;


Route::get('/', function () {
    return view('welcome');
});

// --- RUTAS PÚBLICAS (Callback Libélula) ---
Route::post('/libelula/callback', [LibelulaController::class, 'callback'])->name('libelula.callback');
Route::get('/verificar-pago/{venta}', function (Venta $venta) {
    return response()->json(['estado' => $venta->estado]);
})->name('pago.verificar');
// ---------------------------------------------------------------------------

Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD Y PERFIL
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PAGOS LIBÉLULA (QR)
    Route::get('/pagar-venta-qr/{venta}', [LibelulaController::class, 'generarQR'])->name('pagos.qr');

    // 2. RUTAS DE OPERACIÓN DIARIA
    Route::resource('clientes', ClienteController::class);

    Route::get('/ventas/{venta}/ticket', [VentaController::class, 'generarTicket'])->name('ventas.ticket');
    Route::post('/ventas/{venta}/anular', [VentaController::class, 'anular'])->name('ventas.anular');
    Route::resource('ventas', VentaController::class);

    // Consulta de productos (Disponible para empleados)
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show')->where('producto', '[0-9]+');

    // 3. RUTAS PROTEGIDAS (SOLO ADMIN)
    Route::middleware(['can:admin-only'])->group(function () {
        Route::resource('servicios-nutricionales', ServicioNutricionalController::class);
        Route::resource('categorias', CategoriaController::class);
        Route::resource('productos', ProductoController::class)->except(['index', 'show']);
        Route::resource('almacenes', AlmacenController::class);
        Route::resource('inventarios', InventarioController::class);
        Route::resource('proveedores', ProveedorController::class);
        Route::resource('traspasos', TraspasoController::class);
        Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'usuario']);

    // --- REPORTES ---

        Route::get('/reportes/pdf', [ReporteController::class, 'generarPdf'])->name('reportes.pdf');
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    });
});

require __DIR__.'/auth.php';
