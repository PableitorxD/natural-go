<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Courier', sans-serif; font-size: 12px; width: 100%; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; }
    </style>
</head>
<body>
    <div class="text-center">
        <h2 style="margin-bottom: 0;">NATURAL GO</h2>
        <p style="margin-top: 0;">Sucursal: {{ $venta->almacen->nombre }}</p>
    </div>

    <div class="divider"></div>

    <p><b>Fecha:</b> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
    <p><b>Cliente:</b> {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</p>
    <p><b>Venta Nro:</b> {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</p>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th align="left">Cant. / Producto</th>
                <th align="right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $venta->cantidad }}x {{ $venta->producto->nombre }}</td>
                <td align="right">{{ number_format($venta->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="divider"></div>

    <div style="text-align: right;">
        <p class="bold" style="font-size: 16px;">TOTAL: {{ number_format($venta->total, 2) }} Bs.</p>
        <p>Método: {{ strtoupper($venta->metodo_pago) }}</p>
    </div>

    <div class="text-center" style="margin-top: 20px;">
        <p>¡Gracias por su compra!</p>
        <p>www.naturalgo.com</p>
    </div>
</body>
</html>