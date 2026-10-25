@extends('layouts.guest')

@section('titulo', 'Restablecer contraseña')

@section('contenido')
    <div class="w-full">
        <!-- Top bar de navegación -->
        <div class="flex items-center justify-between mb-8">
            <a href="/login" class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full transition-all group"
               style="background: var(--soft); color: var(--brand-dark); border: 1px solid rgba(67, 143, 194, 0.16);">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver al inicio de sesión</span>
            </a>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full text-blue-700 bg-blue-50 border border-blue-200/70">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-blue-500"></i>
                Token verificado
            </span>
        </div>

        @if (isset($error))
            <!-- Estado de Error / Enlace Expirado -->
            <div class="text-center py-6">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-red-50 border border-red-200 flex items-center justify-center text-red-500 mb-4 shadow-sm">
                    <i data-lucide="alert-octagon" class="w-8 h-8"></i>
                </div>

                <h1 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight" style="color: var(--navy)">
                    Enlace no disponible
                </h1>
                <p class="text-sm mt-3 leading-relaxed max-w-sm mx-auto" style="color: #5C7690">
                    {{ $error }}
                </p>

                <div class="mt-8">
                    <a href="/olvide-password" class="btn-3d inline-flex items-center gap-2 px-6 py-3.5 text-sm rounded-2xl font-semibold shadow-md">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        <span>Solicitar un nuevo enlace</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Encabezado con estética Welcome -->
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-3" style="background: rgba(67, 143, 194, 0.08); border: 1px solid rgba(67, 143, 194, 0.18);">
                    <span class="w-2 h-2 rounded-full" style="background: var(--brand)"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[.14em]" style="color: var(--brand-dark)">Paso final</span>
                </div>

                <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight" style="color: var(--navy)">
                    Restablece tu
                    <span class="relative inline-block">
                        <span style="color: var(--blue-deep)">contraseña</span>
                        <svg class="absolute -bottom-1.5 left-0 w-full" viewBox="0 0 160 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 6 C40 2, 95 2, 158 6" stroke="var(--accent)" stroke-width="3" stroke-linecap="round" opacity=".65"/>
                        </svg>
                    </span>
                </h1>
                <p class="text-sm mt-3 leading-relaxed" style="color: #5C7690">
                    Elige una nueva clave segura para tu cuenta en MyPetts.
                </p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="/restablecer/{{ $token }}" class="space-y-4">
                @csrf

                <!-- Nueva Contraseña -->
                <div class="space-y-1.5">
                    <label for="contrasena" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Nueva contraseña
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input id="contrasena" type="password" name="contrasena" required autofocus
                               placeholder="Mínimo 8 caracteres"
                               class="w-full pl-11 pr-11 py-3.5 text-sm rounded-2xl border transition-all duration-200"
                               style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        <button type="button" onclick="togglePassVisibility('contrasena', this)"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 transition-colors"
                                aria-label="Mostrar contraseña">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="space-y-1.5">
                    <label for="confirmar_contrasena" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Confirmar nueva contraseña
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </span>
                        <input id="confirmar_contrasena" type="password" name="confirmar_contrasena" required
                               placeholder="Repite tu nueva contraseña"
                               class="w-full pl-11 pr-11 py-3.5 text-sm rounded-2xl border transition-all duration-200"
                               style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        <button type="button" onclick="togglePassVisibility('confirmar_contrasena', this)"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 transition-colors"
                                aria-label="Mostrar confirmación">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Indicador visual de requisitos -->
                <div class="p-3.5 rounded-xl border flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs"
                     style="background: var(--soft); border-color: var(--line);">
                    <span class="font-bold text-[11px] uppercase tracking-wider" style="color: var(--brand-dark)">Requisitos:</span>
                    <span id="req-len" class="flex items-center gap-1 text-slate-500">
                        <i data-lucide="check" class="w-3.5 h-3.5 opacity-40"></i> Mínimo 8 caracteres
                    </span>
                    <span id="req-letter" class="flex items-center gap-1 text-slate-500">
                        <i data-lucide="check" class="w-3.5 h-3.5 opacity-40"></i> Letras
                    </span>
                    <span id="req-num" class="flex items-center gap-1 text-slate-500">
                        <i data-lucide="check" class="w-3.5 h-3.5 opacity-40"></i> Números
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
                    <span>Guardar y restablecer</span>
                    <i data-lucide="check" class="w-4 h-4 transition-transform group-hover:scale-110"></i>
                </button>
            </form>
        @endif
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