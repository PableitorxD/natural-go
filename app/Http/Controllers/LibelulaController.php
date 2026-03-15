<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LibelulaController extends Controller
{
    public function generarQR(Venta $venta)
    {
        $endpoint = config('libelula.endpoint');
        $appKey = config('libelula.app_key');

        $venta->load(['cliente', 'producto']);

        // 1. GENERAMOS UN IDENTIFICADOR ÚNICO PARA LIBÉLULA
        // Esto evita que choques con IDs de otros comercios en el entorno de pruebas
        $identificadorUnico = "NATURALGO-" . $venta->id . "-" . time();

        $costoUnitario = $venta->cantidad > 0 ? ($venta->total / $venta->cantidad) : $venta->total;

        $lineasDetalle = [[
            'concepto'       => $venta->producto->nombre ?? 'Producto Venta #' . $venta->id,
            'cantidad'       => (int)($venta->cantidad ?? 1),
            'costo_unitario' => (float)$costoUnitario,
            'descuento_unitario' => 0
        ]];

        $datosCobro = [
            'appkey'               => $appKey,
            'email_cliente'        => $venta->cliente->email ?? 'pablomolina.work@gmail.com',
            'identificador'        => $identificadorUnico, // Enviamos el ID único generado
            'descripcion'          => "Pago Venta #" . $venta->id,
            'nombre_cliente'       => $venta->cliente->nombre,
            'apellido_cliente'     => $venta->cliente->apellido,
            'ci'                   => $venta->cliente->ci ?? '0',
            'monto'                => number_format($venta->total, 2, '.', ''),
            'moneda'               => 'BOB',
            'callback_url'         => route('libelula.callback'),
            'lineas_detalle_deuda' => $lineasDetalle,
        ];

        try {
            $response = Http::post($endpoint, $datosCobro);
            $resultado = $response->json();

            Log::info('Respuesta de Libélula:', (array)$resultado);

            $exito = isset($resultado['error']) && ($resultado['error'] == 0 || $resultado['error'] == 2);

            if (!$exito) {
                $msg = $resultado['mensaje'] ?? 'Error en la pasarela.';
                return back()->with('error', 'Error Pasarela: ' . $msg);
            }

            $qrFinal = $resultado['qr_base64'] ?? ($resultado['qr_simple_url'] ?? null);
            
            $urlPasarela = $resultado['url_pasarela_pagos'] ?? null;
            if (!$urlPasarela && isset($resultado['id_transaccion'])) {
                $urlPasarela = "https://pagos.libelula.bo/?id=" . $resultado['id_transaccion'];
            }

            // Guardamos el identificador único en la referencia para poder encontrarlo en el callback
            Pago::updateOrCreate(
                ['referencia_libelula' => $resultado['id_transaccion'] ?? 'ref_'.$identificadorUnico],
                [
                    'cliente_id' => $venta->cliente_id,
                    'monto' => $venta->total,
                    'estado' => 'pendiente',
                    'qr_image' => $qrFinal,
                ]
            );

            return view('pagos.mostrar_qr', [
                'qr' => $qrFinal,
                'url_pasarela' => $urlPasarela,
                'venta' => $venta
            ]);

        } catch (\Exception $e) {
            Log::error('Error Crítico Libélula: ' . $e->getMessage());
            return back()->with('error', 'Error crítico: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        Log::info('Callback Libélula Recibido:', $request->all());

        // El identificador vendrá como "NATURALGO-ID-TIME"
        $identificadorFull = $request->input('identificador');
        
        if ($identificadorFull) {
            // Extraemos el ID real de la venta (el número del medio)
            $partes = explode('-', $identificadorFull);
            $ventaId = $partes[1] ?? null; 
            
            if ($ventaId) {
                $venta = Venta::find($ventaId);
                if ($venta) {
                    $venta->update(['estado' => 'completado']);
                    
                    Pago::where('referencia_libelula', $request->input('id_transaccion'))
                        ->update(['estado' => 'pagado']);

                    return response()->json(['error' => 0, 'mensaje' => 'Pago exitoso'], 200);
                }
            }
        }
        
        return response()->json(['error' => 1, 'mensaje' => 'No se pudo procesar'], 404);
    }
}