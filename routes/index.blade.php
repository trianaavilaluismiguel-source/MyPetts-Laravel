<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - MyPetts</title>
</head>
<body>
    <h1>Hola, {{ $usuario->nombre }}</h1>

    <p>
        <a href="/mascota">Mascotas</a> |
        <a href="/cita">Citas</a> |
        <a href="/historial/listar">Historial</a> |
        <a href="/vacuna/listar">Vacunas</a> |
        <form method="POST" action="/logout" style="display:inline">
            @csrf
            <button type="submit">Salir</button>
        </form>
    </p>

    @if ($avisosFallidos->isNotEmpty())
        <div style="border:1px solid red; padding:10px">
            <p>Algunos avisos por correo no se pudieron enviar:</p>
            <ul>
                @foreach ($avisosFallidos as $aviso)
                    <li>{{ $aviso->mensaje }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($rolId === 4)
        <h2>Mis mascotas</h2>
        <ul>
            @foreach ($mascotas as $mascota)
                <li><a href="/mascota/ver/{{ $mascota->id }}">{{ $mascota->nombre }}</a></li>
            @endforeach
        </ul>
    @endif

    @if (in_array($rolId, [1, 3]))
        <p>Mascotas activas: {{ $totalMascotas }} | Usuarios: {{ $totalUsuarios }}</p>
    @endif

    <h2>Próximas citas</h2>
    <ul>
        @forelse ($citas as $cita)
            <li>
                {{ $cita->fecha->format('d/m/Y') }} - {{ $cita->hora }}
                @if ($rolId === 4) con {{ $cita->veterinario->nombre ?? 'N/A' }} @endif
                @if ($rolId === 2) - {{ $cita->mascota->nombre ?? 'N/A' }} @endif
                @if (in_array($rolId, [1, 3])) - {{ $cita->mascota->nombre ?? 'N/A' }} ({{ $cita->veterinario->nombre ?? 'N/A' }}) @endif
            </li>
        @empty
            <li>No hay citas próximas.</li>
        @endforelse
    </ul>
</body>
</html>