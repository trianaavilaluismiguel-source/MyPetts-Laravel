@extends('layouts.guest')

@section('titulo', 'Recuperar contraseña')

@section('contenido')
    <div class="w-full">
        <!-- Barra superior de regreso -->
        <div class="flex items-center justify-between mb-8">
            <a href="/login" class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full transition-all group"
               style="background: var(--soft); color: var(--brand-dark); border: 1px solid rgba(67, 143, 194, 0.16);">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver al inicio de sesión</span>
            </a>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full text-amber-700 bg-amber-50 border border-amber-200/70">
                <i data-lucide="key-round" class="w-3.5 h-3.5 text-amber-500"></i>
                Recuperación
            </span>
        </div>

        <!-- Encabezado con estética Welcome -->
        <div class="mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-3" style="background: rgba(67, 143, 194, 0.08); border: 1px solid rgba(67, 143, 194, 0.18);">
                <span class="w-2 h-2 rounded-full" style="background: var(--brand)"></span>
                <span class="text-[11px] font-bold uppercase tracking-[.14em]" style="color: var(--brand-dark)">Seguridad de tu cuenta</span>
            </div>

            <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight" style="color: var(--navy)">
                ¿Olvidaste tu
                <span class="relative inline-block">
                    <span style="color: var(--blue-deep)">contraseña?</span>
                    <svg class="absolute -bottom-1.5 left-0 w-full" viewBox="0 0 160 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 6 C40 2, 95 2, 158 6" stroke="var(--accent)" stroke-width="3" stroke-linecap="round" opacity=".65"/>
                    </svg>
                </span>
            </h1>
            <p class="text-sm mt-3 leading-relaxed" style="color: #5C7690">
                No te preocupes. Escribe tu correo electrónico asociado y te enviaremos un enlace seguro para restablecer tu acceso.
            </p>
        </div>

        <!-- Formulario -->
        <form method="POST" action="/olvide-password" class="space-y-5">
            @csrf

            <!-- Campo Correo -->
            <div class="space-y-1.5">
                <label for="correo" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                    Correo electrónico registrado
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </span>
                    <input id="correo" type="email" name="correo" value="{{ old('correo') }}" required autofocus
                           placeholder="ejemplo@mypetts.com"
                           class="w-full pl-11 pr-4 py-3.5 text-sm rounded-2xl border transition-all duration-200"
                           style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                </div>
                @error('correo')
                    <p class="text-xs font-medium mt-1 text-red-600 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Botón de Envío 3D -->
            <button type="submit"
                    class="btn-3d w-full py-4 text-sm rounded-2xl font-semibold flex items-center justify-center gap-2 group cursor-pointer shadow-md">
                <span>Enviar enlace de recuperación</span>
                <i data-lucide="send" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </button>
        </form>

        <!-- Tarjeta de Ayuda / Garantía -->
        <div class="mt-8 p-4 rounded-2xl border flex items-start gap-3 text-xs"
             style="background: linear-gradient(135deg, rgba(233,246,251,0.6), rgba(255,255,255,0.8)); border-color: var(--line);">
            <div class="w-7 h-7 rounded-xl flex items-center justify-center shrink-0" style="background: var(--soft); color: var(--brand)">
                <i data-lucide="shield-alert" class="w-4 h-4"></i>
            </div>
            <div class="leading-relaxed" style="color: #4A637B">
                <strong class="font-bold block" style="color: var(--navy)">Enlace de un solo uso:</strong>
                El token de restablecimiento caduca en <strong>30 minutos</strong> por protección de tus datos.
            </div>
        </div>

        <!-- Pie de navegación -->
        <p class="mt-8 text-center text-sm" style="color: var(--muted)">
            ¿Recordaste tu contraseña?
            <a href="/login" class="font-bold hover:underline" style="color: var(--brand-dark)">
                Iniciar sesión
            </a>
        </p>
    </div>
@endsection