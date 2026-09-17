@extends('layouts.guest')

@section('titulo', 'Restablecer contraseña')

@section('contenido')
    <h1 class="font-display text-2xl font-bold tracking-tight mb-1" style="color:var(--navy)">Restablecer contraseña</h1>
    <p class="text-sm mb-8" style="color:var(--muted)">Elige tu nueva contraseña.</p>

    @if (isset($error))
        <p class="text-sm mb-4" style="color:#B42318">{{ $error }}</p>
        <a href="/olvide-password" class="text-sm font-semibold hover:underline" style="color:var(--brand)">Solicitar un enlace nuevo</a>
    @else
        <form method="POST" action="/restablecer/{{ $token }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1" style="color:var(--navy)">Nueva contraseña</label>
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
                <label class="block text-sm font-medium mb-1" style="color:var(--navy)">Confirmar contraseña</label>
                <input type="password" name="confirmar_contrasena"
                       class="input-3d w-full px-4 py-3 text-sm rounded-2xl" style="background:var(--soft); border:0">
                @error('confirmar_contrasena') <p class="text-xs mt-1" style="color:#B42318">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-3d w-full py-3.5 text-sm rounded-2xl font-semibold">
                Restablecer
            </button>
        </form>
    @endif
@endsection