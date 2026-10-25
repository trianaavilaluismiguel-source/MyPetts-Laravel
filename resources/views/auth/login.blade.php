@extends('layouts.guest')

@section('titulo', 'Iniciar sesión')

@section('contenido')
    <div class="w-full">
        <!-- Top bar de regreso -->
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('inicio') }}" class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full transition-all group"
               style="background: var(--soft); color: var(--brand-dark); border: 1px solid rgba(67, 143, 194, 0.16);">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver al inicio</span>
            </a>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-1 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Acceso seguro
            </span>
        </div>

        <!-- Encabezado con estilo del welcome -->
        <div class="mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-3" style="background: rgba(67, 143, 194, 0.08); border: 1px solid rgba(67, 143, 194, 0.18);">
                <span class="w-2 h-2 rounded-full" style="background: var(--brand)"></span>
                <span class="text-[11px] font-bold uppercase tracking-[.14em]" style="color: var(--brand-dark)">Plataforma Veterinaria</span>
            </div>

            <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight" style="color: var(--navy)">
                Bienvenido de
                <span class="relative inline-block">
                    <span style="color: var(--blue-deep)">nuevo</span>
                    <svg class="absolute -bottom-1.5 left-0 w-full" viewBox="0 0 120 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 6 C30 2, 70 2, 118 6" stroke="var(--accent)" stroke-width="3" stroke-linecap="round" opacity=".65"/>
                    </svg>
                </span>
            </h1>
            <p class="text-sm mt-3 leading-relaxed" style="color: #5C7690">
                Ingresa tus credenciales para acceder a tus citas, pacientes e historial clínico.
            </p>
        </div>

        <!-- Formulario -->
        <form method="POST" action="/login" class="space-y-5">
            @csrf

            <!-- Campo Correo -->
            <div class="space-y-1.5">
                <label for="correo" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                    Correo electrónico
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

            <!-- Campo Contraseña -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="contrasena" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Contraseña
                    </label>
                    <a href="/olvide-password" class="text-xs font-semibold hover:underline" style="color: var(--brand)">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </span>
                    <input id="contrasena" type="password" name="contrasena" required
                           placeholder="••••••••"
                           class="w-full pl-11 pr-11 py-3.5 text-sm rounded-2xl border transition-all duration-200"
                           style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                    <button type="button" id="togglePasswordBtn"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 rounded-lg text-slate-400 hover:text-slate-600 transition-colors"
                            aria-label="Mostrar u ocultar contraseña">
                        <i data-lucide="eye" id="eyeIcon" class="w-4 h-4"></i>
                    </button>
                </div>
                @error('contrasena')
                    <p class="text-xs font-medium mt-1 text-red-600 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Botón de Envío 3D -->
            <button type="submit"
                    class="btn-3d w-full py-4 text-sm rounded-2xl font-semibold flex items-center justify-center gap-2 group cursor-pointer shadow-md">
                <span>Ingresar al panel</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </button>
        </form>

        <!-- Selector Rápido de Usuarios Demo (Ideal para testing y presentación) -->
        <div class="mt-8 pt-6 border-t" style="border-color: var(--line)">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider" style="color: var(--muted)">Acceso Rápido Demo:</span>
                <span class="text-[11px] font-medium text-slate-500">Demo1234!</span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <button type="button" onclick="llenarDemo('demo.admin.1@mypetts.test', 'Demo1234!')"
                        class="p-2 text-left rounded-xl transition-all border hover:border-[var(--brand)] bg-slate-50 hover:bg-[var(--soft)] group">
                    <span class="font-bold block text-[11px]" style="color: var(--navy)">👑 Admin</span>
                    <span class="text-[10px] text-slate-500 group-hover:text-[var(--brand-dark)] truncate block">demo.admin.1</span>
                </button>
                <button type="button" onclick="llenarDemo('demo.veterinario.1@mypetts.test', 'Demo1234!')"
                        class="p-2 text-left rounded-xl transition-all border hover:border-[var(--brand)] bg-slate-50 hover:bg-[var(--soft)] group">
                    <span class="font-bold block text-[11px]" style="color: var(--navy)">🩺 Veterinario</span>
                    <span class="text-[10px] text-slate-500 group-hover:text-[var(--brand-dark)] truncate block">demo.vet.1</span>
                </button>
                <button type="button" onclick="llenarDemo('demo.recepcionista.1@mypetts.test', 'Demo1234!')"
                        class="p-2 text-left rounded-xl transition-all border hover:border-[var(--brand)] bg-slate-50 hover:bg-[var(--soft)] group">
                    <span class="font-bold block text-[11px]" style="color: var(--navy)">📋 Recepción</span>
                    <span class="text-[10px] text-slate-500 group-hover:text-[var(--brand-dark)] truncate block">demo.recep.1</span>
                </button>
                <button type="button" onclick="llenarDemo('demo.dueno.1@mypetts.test', 'Demo1234!')"
                        class="p-2 text-left rounded-xl transition-all border hover:border-[var(--brand)] bg-slate-50 hover:bg-[var(--soft)] group">
                    <span class="font-bold block text-[11px]" style="color: var(--navy)">🐾 Dueño</span>
                    <span class="text-[10px] text-slate-500 group-hover:text-[var(--brand-dark)] truncate block">demo.dueno.1</span>
                </button>
            </div>
        </div>

        <!-- Pie de Registro -->
        <p class="mt-8 text-center text-sm" style="color: var(--muted)">
            ¿Aún no tienes una cuenta?
            <a href="/registro" class="font-bold hover:underline" style="color: var(--brand-dark)">
                Regístrate gratis
            </a>
        </p>
    </div>

    <script>
        function llenarDemo(correo, pass) {
            const inputCorreo = document.getElementById('correo');
            const inputPass = document.getElementById('contrasena');
            if (inputCorreo && inputPass) {
                inputCorreo.value = correo;
                inputPass.value = pass;
                inputCorreo.classList.add('ring-2', 'ring-emerald-400');
                inputPass.classList.add('ring-2', 'ring-emerald-400');
                setTimeout(() => {
                    inputCorreo.classList.remove('ring-2', 'ring-emerald-400');
                    inputPass.classList.remove('ring-2', 'ring-emerald-400');
                }, 600);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passInput = document.getElementById('contrasena');
            if (toggleBtn && passInput) {
                toggleBtn.addEventListener('click', () => {
                    const isPassword = passInput.type === 'password';
                    passInput.type = isPassword ? 'text' : 'password';
                    toggleBtn.innerHTML = isPassword
                        ? '<i data-lucide="eye-off" class="w-4 h-4"></i>'
                        : '<i data-lucide="eye" class="w-4 h-4"></i>';
                    if (window.lucide) {
                        window.lucide.createIcons();
                    }
                });
            }
        });
    </script>
@endsection