@extends('layouts.auth')

@section('titulo', 'Nueva entrada clínica')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Nueva entrada clínica de {{ $mascota->nombre }}</h1>

    <div class="bg-white rounded-2xl border border-brand-100 p-6 max-w-xl">
        <div class="mb-4 rounded-xl bg-brand-50 border border-brand-100 px-4 py-3 text-sm text-brand-700">
            Registrando {{ $cita->tipo_consulta }} de la cita del {{ $cita->fecha->format('d/m/Y') }} - {{ $cita->hora }}
        </div>

        <form method="POST" action="/historial/crear/{{ $mascota->id }}?cita_id={{ $cita->id }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de consulta</label>
                <textarea name="motivo_consulta" rows="2"
                          class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">{{ old('motivo_consulta') }}</textarea>
                @error('motivo_consulta') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnóstico</label>
                <textarea name="diagnostico" rows="3"
                          class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">{{ old('diagnostico') }}</textarea>
                @error('diagnostico') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tratamiento</label>
                <textarea name="tratamiento" rows="3"
                          class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">{{ old('tratamiento') }}</textarea>
                @error('tratamiento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                <textarea name="observaciones" rows="2"
                          class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">{{ old('observaciones') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl px-5 py-2.5 text-sm transition shadow-sm shadow-brand-600/30">
                    Registrar
                </button>
                <a href="/historial/verHistorial/{{ $mascota->id }}" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
@endsection