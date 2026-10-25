@extends('layouts.auth')

@section('titulo', $mascota->nombre . ' - Ficha de Mascota')

@section('contenido')
    @php
        $rolId = (int) auth()->user()->rol_id;
    @endphp

    <div class="space-y-6 max-w-4xl">
        <!-- Top bar de regreso -->
        <div class="flex items-center justify-between">
            <a href="/mascota" class="inline-flex items-center gap-2 text-xs font-semibold px-3.5 py-2 rounded-full transition-all group border shadow-2xs"
               style="background: #ffffff; border-color: var(--line); color: var(--navy)">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver al directorio</span>
            </a>

            @if (in_array($rolId, [3, 4]))
                <a href="/mascota/editar/{{ $mascota->id }}"
                   class="btn-3d px-4 py-2 text-xs font-semibold rounded-xl inline-flex items-center gap-1.5 shadow-md">
                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                    <span>Editar datos</span>
                </a>
            @endif
        </div>

        <!-- Tarjeta Principal de la Mascota -->
        <div class="rounded-[28px] bg-white border p-6 sm:p-8 shadow-xs relative overflow-hidden"
             style="border-color: var(--line)">

            <!-- Decoración de fondo -->
            <div class="absolute -right-6 -bottom-6 w-48 h-48 rounded-full pointer-events-none"
                 style="background: {{ strtolower($mascota->especie) === 'gato' ? 'rgba(241,154,120,.15)' : 'rgba(141,201,226,.18)' }}; filter: blur(35px);"></div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b" style="border-color: rgba(215, 234, 243, 0.6)">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-3xl flex items-center justify-center font-bold text-3xl shrink-0 border-2 border-white shadow-md"
                         style="background: {{ strtolower($mascota->especie) === 'gato' ? '#fff0e9' : 'var(--soft)' }}; color: {{ strtolower($mascota->especie) === 'gato' ? 'var(--accent)' : 'var(--brand)' }}">
                        @if (strtolower($mascota->especie) === 'gato')
                            🐈
                        @elseif (strtolower($mascota->especie) === 'perro')
                            🐕
                        @else
                            🐾
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight" style="color: var(--navy)">
                                {{ $mascota->nombre }}
                            </h1>
                            @if ($mascota->estado_salud === 'al_dia')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Al día
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Pendiente
                                </span>
                            @endif
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
                            {{ $mascota->especie }} · {{ $mascota->raza }} · ID #{{ $mascota->id }}
                        </p>
                    </div>
                </div>

                <!-- Botón rápido para agendar cita a esta mascota -->
                @if (in_array($rolId, [3, 4]))
                    <a href="/cita/crear" class="btn-3d-ghost px-4 py-2 text-xs font-bold rounded-xl inline-flex items-center gap-1.5 self-start sm:self-auto">
                        <i data-lucide="calendar-plus" class="w-4 h-4" style="color: var(--brand)"></i>
                        <span>Agendar Cita</span>
                    </a>
                @endif
            </div>

            <!-- Grid de Características y Detalles Físicos -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6">
                <div class="p-4 rounded-2xl border" style="background: var(--soft); border-color: rgba(141, 201, 226, 0.4)">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Sexo</span>
                    <span class="text-sm font-extrabold flex items-center gap-1.5" style="color: var(--navy)">
                        <i data-lucide="{{ $mascota->sexo === 'Macho' ? 'sparkles' : 'heart' }}" class="w-3.5 h-3.5" style="color: var(--brand)"></i>
                        {{ $mascota->sexo }}
                    </span>
                </div>

                <div class="p-4 rounded-2xl border" style="background: var(--soft); border-color: rgba(141, 201, 226, 0.4)">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Edad Aproximada</span>
                    <span class="text-sm font-extrabold" style="color: var(--navy)">
                        {{ $mascota->edad }} {{ $mascota->edad === 1 ? 'año' : 'años' }}
                    </span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">{{ $mascota->fecha_nacimiento->format('d/m/Y') }}</span>
                </div>

                <div class="p-4 rounded-2xl border" style="background: var(--soft); border-color: rgba(141, 201, 226, 0.4)">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Peso Registrado</span>
                    <span class="text-sm font-extrabold" style="color: var(--navy)">
                        {{ $mascota->peso }} kg
                    </span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">Control preventivo</span>
                </div>

                <div class="p-4 rounded-2xl border" style="background: var(--soft); border-color: rgba(141, 201, 226, 0.4)">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Propietario / Dueño</span>
                    <span class="text-sm font-extrabold truncate block" style="color: var(--navy)">
                        {{ $mascota->dueno->nombre ?? 'N/A' }}
                    </span>
                    <span class="text-[10px] text-slate-400 block mt-0.5 truncate">{{ $mascota->dueno->telefono ?? 'Sin teléfono' }}</span>
                </div>
            </div>
        </div>

        <!-- Módulos Clínicos Asociados (Historial y Vacunas) -->
        <div class="grid sm:grid-cols-2 gap-5">
            <!-- Tarjeta 1: Historial Clínico -->
            <a href="/historial/verHistorial/{{ $mascota->id }}"
               class="p-6 rounded-[24px] bg-white border hover:border-[var(--brand)] shadow-xs hover:shadow-md transition-all flex items-start justify-between group"
               style="border-color: var(--line)">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <i data-lucide="clipboard-pulse" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base" style="color: var(--navy)">Historial Clínico</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Consulta consultas generales, diagnósticos médicos y tratamientos recetados.
                        </p>
                        <span class="inline-flex items-center gap-1 text-xs font-bold mt-3" style="color: var(--brand)">
                            <span>Ver expediente</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Tarjeta 2: Carnet de Vacunas -->
            <a href="/vacuna/verVacunas/{{ $mascota->id }}"
               class="p-6 rounded-[24px] bg-white border hover:border-[var(--brand)] shadow-xs hover:shadow-md transition-all flex items-start justify-between group"
               style="border-color: var(--line)">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base" style="color: var(--navy)">Carnet de Vacunación</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Revisa el esquema de inmunización, desparasitaciones y próximas dosis preventivas.
                        </p>
                        <span class="inline-flex items-center gap-1 text-xs font-bold mt-3 text-emerald-600">
                            <span>Ver carnet digital</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection