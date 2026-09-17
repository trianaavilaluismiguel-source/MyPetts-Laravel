@extends('layouts.auth')

@section('titulo', 'Agendar cita')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Agendar cita</h1>

    <div class="bg-white rounded-2xl border border-brand-100 p-6 max-w-xl">

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

        <form method="POST" action="/cita/crear" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mascota</label>
                <select name="mascota_id" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    <option value="">Selecciona</option>
                    @foreach ($mascotas as $mascota)
                        <option value="{{ $mascota->id }}" @selected(old('mascota_id') == $mascota->id)>{{ $mascota->nombre }}</option>
                    @endforeach
                </select>
                @error('mascota_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Veterinario</label>
                <select name="veterinario_id" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    <option value="">Selecciona</option>
                    @foreach ($veterinarios as $veterinario)
                        <option value="{{ $veterinario->id }}" @selected(old('veterinario_id') == $veterinario->id)>{{ $veterinario->nombre }}</option>
                    @endforeach
                </select>
                @error('veterinario_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha') }}"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    @error('fecha') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora</label>
                    <select name="hora" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                        <option value="">Selecciona</option>
                        @foreach ($horasDisponibles as $hora)
                            <option value="{{ $hora }}" @selected(old('hora') === $hora)>{{ \Illuminate\Support\Carbon::parse($hora)->format('h:i A') }}</option>
                        @endforeach
                    </select>
                    @error('hora') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de consulta</label>
                <select name="tipo_consulta" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    <option value="">Selecciona</option>
                    @foreach ($tiposConsulta as $tipo)
                        <option value="{{ $tipo }}" @selected(old('tipo_consulta') === $tipo)>{{ $tipo }}</option>
                    @endforeach
                </select>
                @error('tipo_consulta') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl px-5 py-2.5 text-sm transition shadow-sm shadow-brand-600/30">
                    Agendar
                </button>
                <a href="/cita" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
@endsection