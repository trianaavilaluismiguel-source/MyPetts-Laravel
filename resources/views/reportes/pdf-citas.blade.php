<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body>
    <h2 style="text-align:center">MyPetts - Reporte de Citas por Periodo</h2>
    <p style="text-align:center">Periodo: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</p>

    <table border="1" cellpadding="4" style="width:100%; border-collapse:collapse">
        <tr>
            <th>Fecha</th><th>Hora</th><th>Mascota</th><th>Veterinario</th><th>Consulta</th><th>Estado</th>
        </tr>
        @foreach ($datos as $fila)
        <tr>
            <td>{{ date('d/m/Y', strtotime($fila->fecha)) }}</td>
            <td>{{ date('h:i A', strtotime($fila->hora)) }}</td>
            <td>{{ $fila->nombre_mascota }}</td>
            <td>{{ $fila->nombre_veterinario }}</td>
            <td>{{ $fila->tipo_consulta }}</td>
            <td>{{ $fila->estado }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>