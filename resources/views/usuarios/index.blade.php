@extends('layouts.auth')

@section('titulo', 'Usuarios')

@section('contenido')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Gestión de usuarios</h1>
        <a href="/usuario/crear"
           class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition shadow-sm shadow-brand-600/30">
            + Nuevo usuario
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-brand-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50/60 text-gray-600 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Nombre</th>
                    <th class="text-left px-4 py-3 font-medium">Correo</th>
                    <th class="text-left px-4 py-3 font-medium">Teléfono</th>
                    <th class="text-left px-4 py-3 font-medium">Rol</th>
                    <th class="text-left px-4 py-3 font-medium">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse ($usuarios as $usuario)
                    <tr class="hover:bg-brand-50/30">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $usuario->nombre }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $usuario->correo }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $usuario->telefono }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $usuario->rol->nombre_rol }}</td>
                        <td class="px-4 py-3">
                            @if ($usuario->activo)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">Activo</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap space-x-3">
                            <a href="/usuario/editar/{{ $usuario->id }}" class="text-brand-600 hover:underline text-sm">Editar</a>

                            <form method="POST" action="/usuario/resetear/{{ $usuario->id }}" class="inline" onsubmit="return confirm('¿Restablecer la contraseña de este usuario?')">
                                @csrf
                                <button type="submit" class="text-amber-700 hover:underline text-sm">Resetear</button>
                            </form>

                            <form method="POST" action="/usuario/estado/{{ $usuario->id }}" class="inline">
                                @csrf
                                <button type="submit" class="{{ $usuario->activo ? 'text-red-600' : 'text-green-700' }} hover:underline text-sm">
                                    {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay usuarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $usuarios->links() }}</div>
@endsection