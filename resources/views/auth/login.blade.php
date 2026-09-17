@extends('layouts.guest')

@section('titulo', 'Iniciar sesión')

@section('contenido')
    <a href="{{ route('inicio') }}" class="inline-flex items-center gap-1 text-sm mb-6 font-medium hover:underline" style="color:var(--brand)">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Volver al inicio
    </a>

    <h1 class="font-display text-2xl font-bold tracking-tight" style="color:var(--navy)">Iniciar sesión</h1>
    <p class="text-sm mt-1 mb-8" style="color:var(--muted)">Ingresa tus datos para continuar.</p>

    <form method="POST" action="/login" class="space-y-4">
        @csrf
        <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5" style="color:var(--brand)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0-.414.336-.75.75-.75h18c.414 0 .75.336.75.75v10.5a.75.75 0 01-.75.75H3a.75.75 0 01-.75-.75V6.75z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.5l9.75 6.75L21.75 7.5" />
            </svg>
            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="Correo"
                   class="input-3d w-full pl-12 pr-4 py-3.5 text-sm rounded-2xl" style="background:var(--soft); border:0">
        </div>
        <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5" style="color:var(--brand)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <input type="password" name="contrasena" placeholder="Contraseña"
                   class="input-3d w-full pl-12 pr-4 py-3.5 text-sm rounded-2xl" style="background:var(--soft); border:0">
        </div>

        <p class="text-right text-sm">
            <a href="/olvide-password" class="font-medium hover:underline" style="color:var(--brand)">¿Olvidaste tu contraseña?</a>
        </p>

        <button type="submit" class="btn-3d w-full py-3.5 text-sm rounded-2xl font-semibold">
            Iniciar sesión
        </button>
    </form>

    <p class="mt-8 text-center text-sm" style="color:var(--muted)">
        ¿No tienes cuenta?
        <a href="/registro" class="font-semibold hover:underline" style="color:var(--brand)">Regístrate</a>
    </p>
@endsection