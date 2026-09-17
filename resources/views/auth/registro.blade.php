@extends('layouts.guest')

@section('titulo', 'Crear cuenta')

@section('contenido')
    <a href="{{ route('inicio') }}" class="inline-flex items-center gap-1 text-sm mb-6 font-medium hover:underline" style="color:var(--brand)">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Volver al inicio
    </a>

    <h1 class="font-display text-2xl font-bold tracking-tight" style="color:var(--navy)">Crear cuenta</h1>
    <p class="text-sm mt-1 mb-6" style="color:var(--muted)">Regístrate para gestionar a tus mascotas.</p>

    <form method="POST" action="/registro" class="space-y-4">
        @csrf

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--navy)">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"
                       class="input-3d w-full px-4 py-3 text-sm rounded-2xl" style="background:var(--soft); border:0">
                @error('nombre') <p class="text-xs mt-1" style="color:#B42318">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--navy)">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}"
                       class="input-3d w-full px-4 py-3 text-sm rounded-2xl" style="background:var(--soft); border:0">
                @error('telefono') <p class="text-xs mt-1" style="color:#B42318">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:var(--navy)">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}"
                   class="input-3d w-full px-4 py-3 text-sm rounded-2xl" style="background:var(--soft); border:0">
            @error('correo') <p class="text-xs mt-1" style="color:#B42318">{{ $message }}</p> @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--navy)">Contraseña</label>
                <input type="password" name="contrasena"
                       class="input-3d w-full px-4 py-3 text-sm rounded-2xl" style="background:var(--soft); border:0">
                @error('contrasena')
                    <ul class="text-xs mt-1 list-disc list-inside" style="color:#B42318">
                        <li>Mínimo 8 caracteres</li>
                        <li>Al menos una letra</li>
                        <li>Al menos un número</li>
                    </ul>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--navy)">Confirmar</label>
                <input type="password" name="confirmar_contrasena"
                       class="input-3d w-full px-4 py-3 text-sm rounded-2xl" style="background:var(--soft); border:0">
                @error('confirmar_contrasena') <p class="text-xs mt-1" style="color:#B42318">{{ $message }}</p> @enderror
            </div>
        </div>

        <button type="submit" class="btn-3d w-full py-3.5 text-sm rounded-2xl font-semibold">
            Registrarme
        </button>
    </form>

    <p class="mt-6 text-center text-sm" style="color:var(--muted)">
        ¿Ya tienes cuenta?
        <a href="/login" class="font-semibold hover:underline" style="color:var(--brand)">Inicia sesión</a>
    </p>
@endsection