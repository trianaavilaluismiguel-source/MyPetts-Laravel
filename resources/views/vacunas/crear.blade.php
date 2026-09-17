@extends('layouts.auth')

@section('titulo', 'Registrar vacuna')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Registrar aplicación en {{ $mascota->nombre }}</h1>

    <div class="bg-white rounded-2xl border border-brand-100 p-6 max-w-xl">

        @if ($cita)
            <div class="mb-4 rounded-xl bg-brand-50 border border-brand-100 px-4 py-3 text-sm text-brand-700">
                Registrando {{ $cita->tipo_consulta }} de la cita del {{ $cita->fecha->format('d/m/Y') }} - {{ $cita->hora }}
            </div>
        @endif

        <form method="POST" action="/vacuna/crear/{{ $mascota->id }}@if($cita)?cita_id={{ $cita->id }}@endif" class="space-y-4">
            @csrf

            @if (!$cita)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="tipo" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                        <option value="">Selecciona</option>
                        <option value="vacuna" @selected(old('tipo') === 'vacuna')>Vacuna</option>
                        <option value="desparasitacion" @selected(old('tipo') === 'desparasitacion')>Desparasitación</option>
                    </select>
                    @error('tipo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto</label>
                <input type="text" name="nombre_producto" value="{{ old('nombre_producto') }}"
                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                @error('nombre_producto') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lote</label>
                <input type="text" name="lote" value="{{ old('lote') }}"
                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                @error('lote') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de aplicación</label>
                    <input type="date" name="fecha_aplicacion" value="{{ old('fecha_aplicacion') }}"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    @error('fecha_aplicacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Próxima dosis</label>
                    <input type="date" name="fecha_proxima_dosis" value="{{ old('fecha_proxima_dosis') }}"
                           class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    @error('fecha_proxima_dosis') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl px-5 py-2.5 text-sm transition shadow-sm shadow-brand-600/30">
                    Registrar
                </button>
                <a href="/vacuna/verVacunas/{{ $mascota->id }}" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
@endsection