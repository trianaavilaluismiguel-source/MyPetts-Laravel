<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body>
    <h2 style="text-align:center">MyPetts - Reporte de Mascotas Atendidas por Especie</h2>
    <p style="text-align:center">Periodo: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</p>

    <table border="1" cellpadding="4" style="width:100%; border-collapse:collapse">
        <tr>
            <th>Especie</th><th>Periodo actual</th><th>Periodo anterior</th>
        </tr>
        @php
            $especies = array_unique(array_merge(array_keys($datos['actual']), array_keys($datos['anterior'])));
        @endphp
        @foreach ($especies as $especie)
        <tr>
            <td>{{ $especie }}</td>
            <td>{{ $datos['actual'][$especie] ?? 0 }}</td>
            <td>{{ $datos['anterior'][$especie] ?? 0 }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>