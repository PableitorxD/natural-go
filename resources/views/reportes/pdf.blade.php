<!DOCTYPE html>
<html>
<head>
    <title>Reporte Natural Go</title>
    <style>
        body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        color: #333;
        line-height: 1.5;
    }
    .header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #4f46e5; /* Color Índigo como tu botón */
        padding-bottom: 10px;
    }
    .header h1 {
        color: #4f46e5;
        margin: 0;
        text-transform: uppercase;
        font-size: 24px;
    }
    .header p {
        color: #666;
        margin: 5px 0;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }
    .table th {
        background-color: #4f46e5;
        color: white;
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: 1px;
        padding: 10px;
        border: none;
    }
    .table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .table tr:nth-child(even) {
        background-color: #f8fafc;
    }
    .total-box {
        background-color: #ecfdf5; /* Verde claro como en ingresos */
        border-left: 5px solid #10b981;
        padding: 15px;
        text-align: right;
        margin-top: 20px;
    }
    .total-label {
        font-size: 12px;
        color: #065f46;
        font-weight: bold;
    }
    .total-amount {
        font-size: 20px;
        color: #059669;
        font-weight: bold;
    }
    .alerta-header {
        color: #b91c1c;
        border-bottom: 1px solid #fecaca;
        padding-bottom: 5px;
        margin-top: 30px;
    }
    .stock-badge {
        color: #b91c1c;
        font-weight: bold;
        background-color: #fee2e2;
        padding: 2px 8px;
        border-radius: 10px;
    </style>
</head>
<body>
    <div class="header">
        <h1>Natural Go - Reporte de Ventas</h1>
        <p>Periodo: {{ $fecha_inicio }} al {{ $fecha_fin }}</p>
    </div>

    <h3>Resumen de Ventas</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cliente/Vendedor</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $venta->cliente->nombre ?? 'Sin Cliente' }}</td>
                <td>{{ number_format($venta->total, 2) }} Bs.</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <span class="total-label">INGRESOS TOTALES:</span><br>
        <span class="total-amount">{{ number_format($totalIngresos, 2) }} Bs.</span>
    </div>
    <hr>

    <h3>⚠️ Alertas de Stock Crítico</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productosStockBajo as $prod)
            <tr>
                <td>{{ $prod->nombre }}</td>
                <td class="alerta">{{ $prod->stock }} unidades</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
