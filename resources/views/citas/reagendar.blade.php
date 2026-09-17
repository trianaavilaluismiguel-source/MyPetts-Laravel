@extends('layouts.auth')

@section('titulo', 'Reagendar cita')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-2">Reagendar cita</h1>
    <p class="text-sm text-gray-500 mb-6">
        Cita actual: {{ $cita->fecha->format('d/m/Y') }} - {{ \Illuminate\Support\Carbon::parse($cita->hora)->format('h:i A') }}
    </p>

    <div class="bg-white rounded-2xl border border-brand-100 p-6 max-w-md">

        @if (session('sugerencias'))
            <div class="mb-4 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-sm px-4 py-3">
                <p class="font-medium mb-1">Horarios disponibles cercanos:</p>
                <ul class="list-disc list-inside">
                    @foreach (session('sugerencias') as $s)
                        <li>{{ \Illuminate\Support\Carbon::parse($s['fecha'])->format('d/m/Y') }} - {{ \Illuminate\Support\Carbon::parse($s['hora'])->format('h:i A') }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/cita/reagendar/{{ $cita->id }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nueva fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha') }}"
                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                @error('fecha') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nueva hora</label>
                <select name="hora" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    <option value="">Selecciona</option>
                    @foreach ($horasDisponibles as $hora)
                        <option value="{{ $hora }}" @selected(old('hora') === $hora)>{{ \Illuminate\Support\Carbon::parse($hora)->format('h:i A') }}</option>
                    @endforeach
                </select>
                @error('hora') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl px-5 py-2.5 text-sm transition shadow-sm shadow-brand-600/30">
                    Reagendar
                </button>
                <a href="/cita" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
@endsection