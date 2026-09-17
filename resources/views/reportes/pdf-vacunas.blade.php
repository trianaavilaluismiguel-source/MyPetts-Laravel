<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body>
    <h2 style="text-align:center">MyPetts - Reporte de Vacunas Aplicadas</h2>
    <p style="text-align:center">Periodo: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</p>

    <table border="1" cellpadding="4" style="width:100%; border-collapse:collapse">
        <tr>
            <th>Fecha aplic.</th><th>Producto</th><th>Mascota</th><th>Prox. dosis</th>
        </tr>
        @foreach ($datos as $fila)
        <tr>
            <td>{{ date('d/m/Y', strtotime($fila->fecha_aplicacion)) }}</td>
            <td>{{ $fila->nombre_producto }}</td>
            <td>{{ $fila->nombre_mascota }}</td>
            <td>{{ date('d/m/Y', strtotime($fila->fecha_proxima_dosis)) }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>