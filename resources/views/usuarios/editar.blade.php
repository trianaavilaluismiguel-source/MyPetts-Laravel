@extends('layouts.auth')

@section('titulo', 'Editar usuario')

@section('contenido')
    <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Editar usuario</h1>

    <div class="bg-white rounded-2xl border border-brand-100 p-6 max-w-xl">
        <form method="POST" action="/usuario/editar/{{ $usuario->id }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                @error('nombre') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                <input type="email" name="correo" value="{{ old('correo', $usuario->correo) }}"
                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                @error('correo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}"
                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                @error('telefono') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select name="rol_id" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-brand-400">
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}" @selected(old('rol_id', $usuario->rol_id) == $rol->id)>{{ $rol->nombre_rol }}</option>
                    @endforeach
                </select>
                @error('rol_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl px-5 py-2.5 text-sm transition shadow-sm shadow-brand-600/30">
                    Guardar
                </button>
                <a href="/usuario" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
@endsection