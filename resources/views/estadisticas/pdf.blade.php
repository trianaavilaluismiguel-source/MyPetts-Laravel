<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body>
    <h2 style="text-align:center">MyPetts - Reporte de Estadísticas</h2>
    <p style="text-align:center">Periodo: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</p>

    <h3>Indicadores generales</h3>
    <table border="1" cellpadding="4" style="width:100%; border-collapse:collapse">
        <tr><td>Mascotas registradas</td><td>{{ $datos['totalMascotas'] }}</td></tr>
        <tr><td>Citas completadas</td><td>{{ $datos['citasCompletadas'] }}</td></tr>
        <tr><td>Citas canceladas</td><td>{{ $datos['citasCanceladas'] }}</td></tr>
        <tr><td>Citas agendadas</td><td>{{ $datos['citasAgendadas'] }}</td></tr>
        <tr><td>Vacunas/desparasitaciones aplicadas</td><td>{{ $datos['vacunasAplicadas'] }}</td></tr>
    </table>

    <h3>Usuarios activos por rol</h3>
    <table border="1" cellpadding="4" style="width:100%; border-collapse:collapse">
        <tr><th>Rol</th><th>Usuarios activos</th></tr>
        @foreach ($datos['usuariosPorRol'] as $fila)
        <tr>
            <td>{{ $fila->nombre_rol }}</td>
            <td>{{ $fila->total }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>