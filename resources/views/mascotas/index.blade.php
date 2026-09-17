@extends('layouts.auth')

@section('titulo', 'Mascotas')

@section('contenido')
    @php $rolId = (int) auth()->user()->rol_id; @endphp

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Mascotas</h1>
        @if (in_array($rolId, [3, 4]))
            <a href="/mascota/crear"
               class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition shadow-sm shadow-brand-600/30">
                + Registrar mascota
            </a>
        @endif
    </div>

    <form method="GET" action="/mascota" class="mb-5">
        <input type="text" name="busqueda" value="{{ $termino }}" placeholder="Buscar por nombre o especie..."
               class="w-full sm:w-80 rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
    </form>

    <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Nombre</th>
                    <th class="text-left px-4 py-3 font-medium">Especie</th>
                    <th class="text-left px-4 py-3 font-medium">Raza</th>
                    <th class="text-left px-4 py-3 font-medium">Dueño</th>
                    <th class="text-left px-4 py-3 font-medium">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse ($mascotas as $mascota)
                    <tr class="hover:bg-brand-50/30">
                        <td class="px-4 py-3">
                            <a href="/mascota/ver/{{ $mascota->id }}" class="font-medium text-brand-700 hover:underline">{{ $mascota->nombre }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $mascota->especie }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $mascota->raza }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $mascota->dueno->nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            @if ($mascota->estado_salud === 'al_dia')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">Al día</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Pendiente</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            @if (in_array($rolId, [3, 4]))
                                <a href="/mascota/editar/{{ $mascota->id }}" class="text-brand-600 hover:underline text-sm">Editar</a>
                                <form method="POST" action="/mascota/baja/{{ $mascota->id }}" class="inline" onsubmit="return confirm('¿Dar de baja esta mascota?')">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline text-sm ml-3">Dar de baja</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay mascotas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $mascotas->links() }}</div>
@endsection