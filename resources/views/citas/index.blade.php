@extends('layouts.auth')

@section('titulo', 'Citas')

@section('contenido')
    @php $rolId = (int) auth()->user()->rol_id; @endphp

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Citas</h1>
        @if (in_array($rolId, [3, 4]))
            <a href="/cita/crear"
               class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition shadow-sm shadow-brand-600/30">
                + Agendar cita
            </a>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Fecha</th>
                    <th class="text-left px-4 py-3 font-medium">Hora</th>
                    <th class="text-left px-4 py-3 font-medium">Mascota</th>
                    <th class="text-left px-4 py-3 font-medium">Veterinario</th>
                    <th class="text-left px-4 py-3 font-medium">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse ($citas as $cita)
                    <tr class="hover:bg-brand-50/30">
                        <td class="px-4 py-3 text-gray-900 font-medium">{{ $cita->fecha->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Illuminate\Support\Carbon::parse($cita->hora)->format('h:i A') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $cita->mascota->nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $cita->veterinario->nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colores = [
                                    'agendada' => 'bg-brand-50 text-brand-700',
                                    'completada' => 'bg-green-50 text-green-700',
                                    'cancelada' => 'bg-red-50 text-red-700',
                                    'reagendada' => 'bg-amber-50 text-amber-700',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $colores[$cita->estado] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap space-x-3">
                            @if ($cita->estado === 'agendada')
                                @if (in_array($rolId, [3, 4]))
                                    <a href="/cita/reagendar/{{ $cita->id }}" class="text-brand-600 hover:underline text-sm">Reagendar</a>
                                    <form method="POST" action="/cita/cancelar/{{ $cita->id }}" class="inline" onsubmit="return confirm('¿Cancelar esta cita?')">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Cancelar</button>
                                    </form>
                                @endif
                                @if ($rolId === 2 && $cita->veterinario_id === auth()->id())
                                    <form method="POST" action="/cita/atender/{{ $cita->id }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-700 hover:underline text-sm">Atender</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay citas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $citas->links() }}</div>
@endsection