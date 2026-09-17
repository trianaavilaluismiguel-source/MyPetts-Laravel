@extends('layouts.auth')

@section('titulo', 'Historial de ' . $mascota->nombre)

@section('contenido')
    @php $rolId = (int) auth()->user()->rol_id; @endphp

    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Historial clínico de {{ $mascota->nombre }}</h1>

    <form method="GET" action="/historial/verHistorial/{{ $mascota->id }}" class="flex flex-wrap gap-3 mb-5">
        <input type="date" name="desde" value="{{ $filtros['desde'] }}"
               class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
        <input type="date" name="hasta" value="{{ $filtros['hasta'] }}"
               class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
        <select name="tipo_consulta" class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
            <option value="">Todos los tipos</option>
            @foreach ($tiposConsulta as $tipo)
                <option value="{{ $tipo }}" @selected($filtros['tipo_consulta'] === $tipo)>{{ $tipo }}</option>
            @endforeach
        </select>
        <input type="text" name="diagnostico" value="{{ $filtros['diagnostico'] }}" placeholder="Buscar diagnóstico..."
               class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
        <button type="submit" class="bg-brand-100 hover:bg-brand-200 text-brand-700 text-sm font-medium px-4 py-2 rounded-xl transition">Filtrar</button>
    </form>

    <div class="space-y-4">
        @forelse ($entradas as $entrada)
            <div class="bg-white rounded-2xl border border-brand-100 p-5">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-brand-50 text-brand-700">{{ $entrada->tipo_consulta }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $entrada->fecha_registro->format('d/m/Y H:i') }} · Dr(a). {{ $entrada->veterinario->nombre ?? 'N/A' }}</span>
                    </div>
                    @if ($entrada->puedeEditar() && $rolId === 2)
                        <a href="/historial/editar/{{ $entrada->id }}" class="text-brand-600 hover:underline text-sm">Editar</a>
                    @endif
                </div>
                <p class="text-sm text-gray-700 mb-1"><span class="font-medium text-gray-900">Motivo:</span> {{ $entrada->motivo_consulta }}</p>
                <p class="text-sm text-gray-700 mb-1"><span class="font-medium text-gray-900">Diagnóstico:</span> {{ $entrada->diagnostico }}</p>
                <p class="text-sm text-gray-700 mb-1"><span class="font-medium text-gray-900">Tratamiento:</span> {{ $entrada->tratamiento }}</p>
                @if ($entrada->observaciones)
                    <p class="text-sm text-gray-500"><span class="font-medium text-gray-900">Observaciones:</span> {{ $entrada->observaciones }}</p>
                @endif
            </div>
        @empty
            <p class="text-sm text-gray-500">No hay entradas registradas.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $entradas->links() }}</div>

    <a href="/mascota/ver/{{ $mascota->id }}" class="inline-block mt-6 text-sm text-gray-500 hover:underline">Volver a la ficha</a>
@endsection