@extends('layouts.auth')

@section('titulo', 'Estadísticas')

@section('contenido')
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-7">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[.18em]" style="color:var(--accent)">Resumen operativo</p>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight mt-2">Panel de estadísticas</h1>
            <p class="text-sm mt-2 text-gray-500">Una lectura rápida de la actividad de MyPetts.</p>
        </div>
        @if (!$sinDatos)
            <span class="inline-flex items-center gap-2 self-start sm:self-auto rounded-full px-3 py-2 text-xs font-semibold" style="background:var(--soft); color:var(--brand-dark)">
                <span class="w-2 h-2 rounded-full" style="background:#67c58b"></span>
                Datos actualizados
            </span>
        @endif
    </div>

    @if ($sinDatos)

        <div class="bg-white rounded-2xl border border-brand-100 p-6">
            <p class="text-sm text-gray-500">Aún no hay datos suficientes para mostrar estadísticas.</p>
        </div>

    @else

        <section class="bg-white rounded-3xl border border-brand-100 p-5 sm:p-6 mb-6" style="box-shadow:var(--shadow-sm)">
            <div class="flex items-center justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--brand)">Periodo de análisis</p>
                    <p class="text-sm mt-1 text-gray-500">Selecciona las fechas que quieres revisar.</p>
                </div>
                <span class="hidden sm:inline-flex w-10 h-10 rounded-2xl items-center justify-center" style="background:var(--soft); color:var(--brand)">↗</span>
            </div>
            <form method="GET" action="/estadisticas" class="grid sm:grid-cols-2 lg:grid-cols-4 items-end gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Desde</label>
                    <input type="date" name="desde" value="{{ $desde }}"
                           class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Hasta</label>
                    <input type="date" name="hasta" value="{{ $hasta }}"
                           class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-700 pb-2.5 sm:col-span-2 lg:col-span-1">
                    <input type="checkbox" name="comparar" value="1" @checked($comparar)
                           class="rounded border-gray-300 text-brand-600 focus:ring-brand-400">
                    Comparar con otro período
                </label>

                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition shadow-sm shadow-brand-600/30">
                    Consultar
                </button>
            <div class="mt-5 pt-5 border-t border-brand-100">
                <p class="text-xs font-semibold uppercase tracking-wide mb-3" style="color:var(--accent)">Periodo de comparación</p>
                <div class="grid sm:grid-cols-2 gap-4 max-w-lg">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Desde</label>
                        <input type="date" name="desde2" value="{{ $desde2 }}"
                               class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Hasta</label>
                        <input type="date" name="hasta2" value="{{ $hasta2 }}"
                               class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    </div>
                </div>
            </div>
            </form>
        </section>

        @php
            $queryExport = 'desde=' . urlencode($desde) . '&hasta=' . urlencode($hasta);
        @endphp
        <div class="flex flex-wrap items-center justify-between gap-3 mb-7">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--brand)">Vista general</p>
                <p class="text-sm text-gray-500 mt-1">Resultados del {{ $desde }} al {{ $hasta }}.</p>
            </div>
            <div class="flex gap-2">
            <a href="/estadisticas/pdf?{{ $queryExport }}" target="_blank"
               class="text-sm font-medium text-brand-700 border border-brand-200 rounded-xl px-4 py-2 hover:bg-brand-50 transition">Exportar PDF</a>
            <a href="/estadisticas/excel?{{ $queryExport }}" target="_blank"
               class="text-sm font-medium text-brand-700 border border-brand-200 rounded-xl px-4 py-2 hover:bg-brand-50 transition">Exportar Excel</a>
            </div>
        </div>

        @php
            $indicadores = [
                'Mascotas registradas' => ['clave' => 'totalMascotas', 'color' => 'var(--brand)'],
                'Citas completadas' => ['clave' => 'citasCompletadas', 'color' => '#67b98b'],
                'Citas canceladas' => ['clave' => 'citasCanceladas', 'color' => '#df8585'],
                'Citas agendadas' => ['clave' => 'citasAgendadas', 'color' => 'var(--accent)'],
                'Vacunas aplicadas' => ['clave' => 'vacunasAplicadas', 'color' => '#8c86c9'],
            ];
        @endphp
        <div class="grid sm:grid-cols-2 xl:grid-cols-5 gap-3 mb-7">
            @foreach ($indicadores as $etiqueta => $indicador)
                <div class="bg-white rounded-2xl border border-brand-100 p-5" style="box-shadow:var(--shadow-sm); border-top:3px solid {{ $indicador['color'] }}">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $etiqueta }}</p>
                    <p class="text-3xl font-bold mt-3" style="color:var(--ink)">{{ $datos[$indicador['clave']] }}</p>
                    <p class="text-xs mt-2" style="color:var(--muted)">En el periodo seleccionado</p>
                </div>
            @endforeach
        </div>

        @if ($comparar)
        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden mb-6">
            <div class="p-5 border-b border-brand-100">
                <p class="font-semibold" style="color:var(--ink)">Comparativa de periodos</p>
                <p class="text-sm mt-1 text-gray-500">Observa cómo cambió cada indicador frente al periodo anterior.</p>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Indicador</th>
                        <th class="text-left px-4 py-3 font-medium">{{ $desde }} a {{ $hasta }}</th>
                        @if ($comparar)
                            <th class="text-left px-4 py-3 font-medium">{{ $desde2 }} a {{ $hasta2 }}</th>
                            <th class="text-left px-4 py-3 font-medium">Variación</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @foreach ($indicadores as $etiqueta => $indicador)
                        @php $clave = $indicador['clave']; @endphp
                        <tr class="hover:bg-brand-50/30">
                            <td class="px-4 py-3 text-gray-600">{{ $etiqueta }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $datos[$clave] }}</td>
                            @if ($comparar)
                                @php
                                    $actual = $datos[$clave];
                                    $anterior = $datosComparacion[$clave];
                                    $pct = $anterior > 0 ? round((($actual - $anterior) / $anterior) * 100, 1) : ($actual > 0 ? 100.0 : null);
                                @endphp
                                <td class="px-4 py-3 text-gray-600">{{ $anterior }}</td>
                                <td class="px-4 py-3">
                                    @if ($pct === null)
                                        <span class="text-gray-400">—</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $pct >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                            {{ $pct >= 0 ? '▲' : '▼' }} {{ abs($pct) }}%
                                        </span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
            <div class="p-5 border-b border-brand-100">
                <p class="font-semibold" style="color:var(--ink)">Usuarios activos por rol</p>
                <p class="text-sm mt-1 text-gray-500">Distribución del equipo actualmente activo.</p>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Rol</th>
                        <th class="text-left px-4 py-3 font-medium">Usuarios activos</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @foreach ($datos['usuariosPorRol'] as $fila)
                        <tr class="hover:bg-brand-50/30">
                            <td class="px-4 py-3 text-gray-600">{{ $fila->nombre_rol }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $fila->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif
@endsection