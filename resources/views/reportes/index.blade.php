@extends('layouts.auth')

@section('titulo', 'Reportes')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Reportes</h1>

    <div class="bg-white rounded-2xl border border-brand-100 p-6 mb-6">
        <form method="GET" action="/reporte" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de reporte</label>
                <select name="tipo" onchange="this.form.submit()" class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    <option value="citas" @selected($tipo === 'citas')>Citas por período</option>
                    <option value="vacunas" @selected($tipo === 'vacunas')>Vacunas aplicadas</option>
                    <option value="mascotas" @selected($tipo === 'mascotas')>Mascotas atendidas</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                <input type="date" name="desde" value="{{ $desde }}"
                       class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                <input type="date" name="hasta" value="{{ $hasta }}"
                       class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
            </div>

            @if ($tipo === 'vacunas')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mascota</label>
                    <select name="mascota_id" class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                        <option value="">-- Todas --</option>
                        @foreach ($mascotas as $mascota)
                            <option value="{{ $mascota->id }}" @selected($mascotaId === $mascota->id)>{{ $mascota->nombres }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Veterinario</label>
                    <select name="veterinario_id" class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                        <option value="">-- Todos --</option>
                        @foreach ($veterinarios as $veterinario)
                            <option value="{{ $veterinario->id }}" @selected($veterinarioId === $veterinario->id)>{{ $veterinario->nombres}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition shadow-sm shadow-brand-600/30">
                Generar
            </button>
        </form>
    </div>

    @php
        $queryExport = 'tipo=' . urlencode($tipo) . '&desde=' . urlencode($desde) . '&hasta=' . urlencode($hasta);
        if ($tipo === 'vacunas') {
            if ($mascotaId) $queryExport .= '&mascota_id=' . $mascotaId;
            if ($veterinarioId) $queryExport .= '&veterinario_id=' . $veterinarioId;
        }
    @endphp

    @if (!$sinDatos)
        <div class="flex gap-3 mb-5">
            <a href="/reporte/pdf?{{ $queryExport }}" target="_blank"
               class="text-sm font-medium text-brand-700 border border-brand-200 rounded-xl px-4 py-2 hover:bg-brand-50 transition">Exportar PDF</a>
            <a href="/reporte/excel?{{ $queryExport }}" target="_blank"
               class="text-sm font-medium text-brand-700 border border-brand-200 rounded-xl px-4 py-2 hover:bg-brand-50 transition">Exportar Excel</a>
        </div>
    @endif

    @if ($sinDatos)

        <p class="text-sm text-gray-500">No hay datos para el período seleccionado.</p>

    @elseif ($tipo === 'citas')

        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Fecha</th>
                        <th class="text-left px-4 py-3 font-medium">Hora</th>
                        <th class="text-left px-4 py-3 font-medium">Mascota</th>
                        <th class="text-left px-4 py-3 font-medium">Veterinario</th>
                        <th class="text-left px-4 py-3 font-medium">Consulta</th>
                        <th class="text-left px-4 py-3 font-medium">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @foreach ($datos as $fila)
                        <tr class="hover:bg-brand-50/30">
                            <td class="px-4 py-3 ">{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($fila->hora)->format('h:i A') }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $fila->nombre_mascota }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $fila->nombre_veterinario }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $fila->tipo_consulta }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ ucfirst($fila->estado) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @elseif ($tipo === 'vacunas')

        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Fecha aplic.</th>
                        <th class="text-left px-4 py-3 font-medium">Producto</th>
                        <th class="text-left px-4 py-3 font-medium">Tipo</th>
                        <th class="text-left px-4 py-3 font-medium">Mascota</th>
                        <th class="text-left px-4 py-3 font-medium">Veterinario</th>
                        <th class="text-left px-4 py-3 font-medium">Próx. dosis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @foreach ($datos as $fila)
                        <tr class="hover:bg-brand-50/30">
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($fila->fecha_aplicacion)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $fila->nombre_producto }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ ucfirst($fila->tipo) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $fila->nombre_mascota }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $fila->nombre_veterinario }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($fila->fecha_proxima_dosis)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @elseif ($tipo === 'mascotas')

        @php
            $especies = array_unique(array_merge(array_keys($datos['actual']), array_keys($datos['anterior'])));
        @endphp
        <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium">Especie</th>
                        <th class="text-left px-4 py-3 font-medium">Período actual</th>
                        <th class="text-left px-4 py-3 font-medium">Período anterior</th>
                        <th class="text-left px-4 py-3 font-medium">Variación</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @foreach ($especies as $especie)
                        @php
                            $actual = $datos['actual'][$especie] ?? 0;
                            $anterior = $datos['anterior'][$especie] ?? 0;
                            $pct = $anterior > 0 ? round((($actual - $anterior) / $anterior) * 100, 1) : ($actual > 0 ? 100.0 : null);
                        @endphp
                        <tr class="hover:bg-brand-50/30">
                            <td class="px-4 py-3">{{ $especie }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $actual }}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif
@endsection