@extends('layouts.auth')

@section('titulo', 'Vacunas de ' . $mascota->nombre)

@section('contenido')
    @php $rolId = (int) auth()->user()->rol_id; @endphp

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Vacunas y desparasitaciones de {{ $mascota->nombre }}</h1>
        @if ($rolId === 2)
            <a href="/vacuna/mostrarCrear/{{ $mascota->id }}"
               class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition shadow-sm shadow-brand-600/30">
                + Registrar aplicación
            </a>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Tipo</th>
                    <th class="text-left px-4 py-3 font-medium">Producto</th>
                    <th class="text-left px-4 py-3 font-medium">Lote</th>
                    <th class="text-left px-4 py-3 font-medium">Aplicación</th>
                    <th class="text-left px-4 py-3 font-medium">Próxima dosis</th>
                    <th class="text-left px-4 py-3 font-medium">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse ($registros as $registro)
                    <tr class="hover:bg-brand-50/30">
                        <td class="px-4 py-3 text-gray-900 font-medium">{{ $registro->tipo === 'vacuna' ? 'Vacuna' : 'Desparasitación' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $registro->nombre_producto }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $registro->lote }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $registro->fecha_aplicacion->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $registro->fecha_proxima_dosis->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colores = ['vencida' => 'bg-red-50 text-red-700', 'proxima' => 'bg-amber-50 text-amber-700', 'vigente' => 'bg-green-50 text-green-700'];
                                $etiquetas = ['vencida' => 'Vencida', 'proxima' => 'Próxima', 'vigente' => 'Vigente'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $colores[$registro->estado_alerta] }}">
                                {{ $etiquetas[$registro->estado_alerta] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $registros->links() }}</div>

    <a href="/mascota/ver/{{ $mascota->id }}" class="inline-block mt-6 text-sm text-gray-500 hover:underline">Volver a la ficha</a>
@endsection