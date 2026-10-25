@extends('layouts.guest')

@section('titulo', 'Crear cuenta')

@section('contenido')
    <div class="w-full">
        <!-- Top bar de navegación -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('inicio') }}" class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full transition-all group"
               style="background: var(--soft); color: var(--brand-dark); border: 1px solid rgba(67, 143, 194, 0.16);">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver al inicio</span>
            </a>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full text-indigo-700 bg-indigo-50 border border-indigo-200/60">
                <i data-lucide="sparkles" class="w-3 h-3 text-indigo-500"></i>
                Registro gratuito
            </span>
        </div>

        <!-- Encabezado con estética Welcome -->
        <div class="mb-7">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-3" style="background: rgba(67, 143, 194, 0.08); border: 1px solid rgba(67, 143, 194, 0.18);">
                <span class="w-2 h-2 rounded-full" style="background: var(--accent)"></span>
                <span class="text-[11px] font-bold uppercase tracking-[.14em]" style="color: var(--brand-dark)">Comienza hoy</span>
            </div>

            <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight" style="color: var(--navy)">
                Crea tu cuenta en
                <span class="relative inline-block">
                    <span style="color: var(--blue-deep)">MyPetts</span>
                    <svg class="absolute -bottom-1.5 left-0 w-full" viewBox="0 0 140 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 6 C35 2, 85 2, 138 6" stroke="var(--accent)" stroke-width="3" stroke-linecap="round" opacity=".65"/>
                    </svg>
                </span>
            </h1>
            <p class="text-sm mt-3 leading-relaxed" style="color: #5C7690">
                Únete a nuestra comunidad para agendar citas, llevar el historial clínico y el carnet de vacunas de tus mascotas.
            </p>
        </div>

        <!-- Formulario -->
        <form method="POST" action="/registro" class="space-y-4">
            @csrf

            <!-- Nombre Completo y Teléfono en dos columnas -->
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="nombre" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Nombre completo
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" required autofocus
                               placeholder="Carlos Mendoza"
                               class="w-full pl-11 pr-4 py-3 text-sm rounded-2xl border transition-all duration-200"
                               style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                    </div>
                    @error('nombre')
                        <p class="text-xs font-medium mt-1 text-red-600 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="telefono" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Teléfono / Móvil
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </span>
                        <input id="telefono" type="tel" name="telefono" value="{{ old('telefono') }}" required
                               placeholder="300 123 4567"
                               class="w-full pl-11 pr-4 py-3 text-sm rounded-2xl border transition-all duration-200"
                               style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                    </div>
                    @error('telefono')
                        <p class="text-xs font-medium mt-1 text-red-600 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Correo Electrónico -->
            <div class="space-y-1.5">
                <label for="correo" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                    Correo electrónico
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </span>
                    <input id="correo" type="email" name="correo" value="{{ old('correo') }}" required
                           placeholder="tu@correo.com"
                           class="w-full pl-11 pr-4 py-3 text-sm rounded-2xl border transition-all duration-200"
                           style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                </div>
                @error('correo')
                    <p class="text-xs font-medium mt-1 text-red-600 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Contraseña y Confirmar Contraseña en dos columnas -->
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="contrasena" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Contraseña
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input id="contrasena" type="password" name="contrasena" required
                               placeholder="Mínimo 8 caracteres"
                               class="w-full pl-11 pr-10 py-3 text-sm rounded-2xl border transition-all duration-200"
                               style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        <button type="button" onclick="togglePassVisibility('contrasena', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 transition-colors"
                                aria-label="Mostrar contraseña">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="confirmar_contrasena" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Confirmar contraseña
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </span>
                        <input id="confirmar_contrasena" type="password" name="confirmar_contrasena" required
                               placeholder="Repite tu contraseña"
                               class="w-full pl-11 pr-10 py-3 text-sm rounded-2xl border transition-all duration-200"
                               style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        <button type="button" onclick="togglePassVisibility('confirmar_contrasena', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 transition-colors"
                                aria-label="Mostrar confirmación">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Indicador visual de requerimientos de contraseña -->
            <div class="p-3 rounded-xl border flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs"
                 style="background: var(--soft); border-color: var(--line);">
                <span class="font-bold text-[11px] uppercase tracking-wider" style="color: var(--brand-dark)">Requisitos:</span>
                <span id="req-len" class="flex items-center gap-1 text-slate-500">
                    <i data-lucide="check" class="w-3.5 h-3.5 opacity-40"></i> Mínimo 8 caracteres
                </span>
                <span id="req-letter" class="flex items-center gap-1 text-slate-500">
                    <i data-lucide="check" class="w-3.5 h-3.5 opacity-40"></i> Al menos una letra
                </span>
                <span id="req-num" class="flex items-center gap-1 text-slate-500">
                    <i data-lucide="check" class="w-3.5 h-3.5 opacity-40"></i> Al menos un número
                </span>
            </div>

            @error('contrasena')
                <p class="text-xs font-medium text-red-600 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror
            @error('confirmar_contrasena')
                <p class="text-xs font-medium text-red-600 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror

            <!-- Botón de Envío 3D -->
            <button type="submit"
                    class="btn-3d w-full py-4 text-sm rounded-2xl font-semibold flex items-center justify-center gap-2 group cursor-pointer shadow-md mt-2">
                <span>Crear mi cuenta gratuita</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </button>
        </form>

        <!-- Beneficios en píldoras -->
        <div class="mt-6 pt-5 border-t grid grid-cols-3 gap-2 text-center text-[11px] font-semibold" style="border-color: var(--line)">
            <div class="flex items-center justify-center gap-1.5" style="color: var(--brand-dark)">
                <i data-lucide="clock" class="w-3.5 h-3.5" style="color: var(--brand)"></i>
                <span>Citas 24/7</span>
            </div>
            <div class="flex items-center justify-center gap-1.5" style="color: var(--brand-dark)">
                <i data-lucide="file-heart" class="w-3.5 h-3.5" style="color: var(--accent)"></i>
                <span>Historial digital</span>
            </div>
            <div class="flex items-center justify-center gap-1.5" style="color: var(--brand-dark)">
                <i data-lucide="shield-check" class="w-3.5 h-3.5" style="color: var(--brand)"></i>
                <span>Vacunas al día</span>
            </div>
        </div>

        <!-- Enlace a Inicio de Sesión -->
        <p class="mt-6 text-center text-sm" style="color: var(--muted)">
            ¿Ya tienes una cuenta registrada?
            <a href="/login" class="font-bold hover:underline" style="color: var(--brand-dark)">
                Inicia sesión aquí
            </a>
        </p>
    </div>

    <script>
        function togglePassVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.innerHTML = isPassword
                ? '<i data-lucide="eye-off" class="w-4 h-4"></i>'
                : '<i data-lucide="eye" class="w-4 h-4"></i>';
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        // Feedback interactivo en tiempo real para los requisitos de contraseña
        document.addEventListener('DOMContentLoaded', () => {
            const passInput = document.getElementById('contrasena');
            const reqLen = document.getElementById('req-len');
            const reqLetter = document.getElementById('req-letter');
            const reqNum = document.getElementById('req-num');

            if (passInput) {
                passInput.addEventListener('input', () => {
                    const val = passInput.value;
                    updateRequirement(reqLen, val.length >= 8);
                    updateRequirement(reqLetter, /[A-Za-z]/.test(val));
                    updateRequirement(reqNum, /[0-9]/.test(val));
                });
            }

            function updateRequirement(el, isValid) {
                if (!el) return;
                const icon = el.querySelector('i, svg');
                if (isValid) {
                    el.classList.remove('text-slate-500');
                    el.classList.add('text-emerald-700', 'font-semibold');
                    if (icon) {
                        icon.classList.remove('opacity-40');
                        icon.classList.add('text-emerald-500');
                    }
                } else {
                    el.classList.remove('text-emerald-700', 'font-semibold');
                    el.classList.add('text-slate-500');
                    if (icon) {
                        icon.classList.add('opacity-40');
                        icon.classList.remove('text-emerald-500');
                    }
                }
            }
        });
    </script>
@endsection