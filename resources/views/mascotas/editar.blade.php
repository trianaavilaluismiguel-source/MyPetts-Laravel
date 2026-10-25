@extends('layouts.auth')

@section('titulo', 'Editar ' . $mascota->nombre)

@section('contenido')
    <div class="space-y-6 max-w-2xl">
        <!-- Top bar de navegación -->
        <div class="flex items-center justify-between">
            <a href="/mascota/ver/{{ $mascota->id }}" class="inline-flex items-center gap-2 text-xs font-semibold px-3.5 py-2 rounded-full transition-all group border shadow-2xs"
               style="background: #ffffff; border-color: var(--line); color: var(--navy)">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver a la ficha</span>
            </a>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full text-amber-800 bg-amber-50 border border-amber-200/60">
                <i data-lucide="pencil" class="w-3.5 h-3.5 text-amber-600"></i>
                Modificando registro
            </span>
        </div>

        <!-- Tarjeta de Edición con Estilo Welcome -->
        <div class="rounded-[28px] bg-white border p-6 sm:p-8 shadow-xs relative overflow-hidden"
             style="border-color: var(--line)">

            <!-- Header del formulario -->
            <div class="mb-6 pb-5 border-b" style="border-color: rgba(215, 234, 243, 0.6)">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-2" style="background: rgba(67, 143, 194, 0.08); border: 1px solid rgba(67, 143, 194, 0.18);">
                    <span class="w-2 h-2 rounded-full" style="background: var(--accent)"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[.14em]" style="color: var(--brand-dark)">Actualización</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight" style="color: var(--navy)">Editar Datos de {{ $mascota->nombre }}</h1>
                <p class="text-xs text-slate-500 mt-1">Actualiza los datos físicos o el estado de salud del paciente.</p>
            </div>

            <form method="POST" action="/mascota/editar/{{ $mascota->id }}" class="space-y-4">
                @csrf

                <!-- Nombre -->
                <div class="space-y-1.5">
                    <label for="nombre" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Nombre de la mascota
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="tag" class="w-4 h-4"></i>
                        </span>
                        <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $mascota->nombre) }}" required autofocus
                               class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                               style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                    </div>
                    @error('nombre')
                        <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Especie y Raza en 2 Columnas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="especie" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Especie
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                                <i data-lucide="paw-print" class="w-4 h-4"></i>
                            </span>
                            <input id="especie" type="text" name="especie" value="{{ old('especie', $mascota->especie) }}" required
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                   style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        </div>
                        @error('especie')
                            <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="raza" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Raza
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="dna" class="w-4 h-4"></i>
                            </span>
                            <input id="raza" type="text" name="raza" value="{{ old('raza', $mascota->raza) }}" required
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                   style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        </div>
                        @error('raza')
                            <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Fecha de Nacimiento y Sexo en 2 Columnas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="fecha_nacimiento" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Fecha de nacimiento
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </span>
                            <input id="fecha_nacimiento" type="date" name="fecha_nacimiento"
                                   value="{{ old('fecha_nacimiento', $mascota->fecha_nacimiento->format('Y-m-d')) }}" required
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                   style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        </div>
                        @error('fecha_nacimiento')
                            <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="sexo" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Sexo
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="venus-and-mars" class="w-4 h-4"></i>
                            </span>
                            <select id="sexo" name="sexo" required
                                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                    style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                                <option value="Macho" @selected(old('sexo', $mascota->sexo) === 'Macho')>Macho</option>
                                <option value="Hembra" @selected(old('sexo', $mascota->sexo) === 'Hembra')>Hembra</option>
                            </select>
                        </div>
                        @error('sexo')
                            <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Peso y Estado de Salud en 2 Columnas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="peso" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Peso (kg)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="scale" class="w-4 h-4"></i>
                            </span>
                            <input id="peso" type="number" step="0.1" name="peso" value="{{ old('peso', $mascota->peso) }}" required
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                   style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        </div>
                        @error('peso')
                            <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="estado_salud" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Estado de salud clínico
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="activity" class="w-4 h-4"></i>
                            </span>
                            <select id="estado_salud" name="estado_salud"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                    style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                                <option value="al_dia" @selected(old('estado_salud', $mascota->estado_salud) === 'al_dia')>Al día (Sin pendientes)</option>
                                <option value="pendiente_atencion" @selected(old('estado_salud', $mascota->estado_salud) === 'pendiente_atencion')>Pendiente de atención / control</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center gap-3 pt-4 border-t" style="border-color: rgba(215, 234, 243, 0.6)">
                    <button type="submit" class="btn-3d px-6 py-3 text-sm font-semibold rounded-xl flex items-center gap-2 cursor-pointer shadow-md">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Actualizar mascota</span>
                    </button>
                    <a href="/mascota/ver/{{ $mascota->id }}" class="btn-3d-ghost px-5 py-3 text-sm font-semibold rounded-xl">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection