@extends('layouts.auth')

@section('titulo', 'Directorio de Mascotas')

@section('contenido')
    @php
        $rolId = (int) auth()->user()->rol_id;
    @endphp

    <div class="space-y-6">
        <!-- Banner de Encabezado Superior -->
        <div class="rounded-[28px] p-6 sm:p-8 border shadow-xs relative overflow-hidden"
             style="background: linear-gradient(135deg, #e4f5fb, #f7fcfe 55%, #fff6f0); border-color: rgba(166, 208, 228, 0.7);">

            <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full pointer-events-none" style="background: rgba(141, 201, 226, .3); filter: blur(35px);"></div>
            <div class="absolute -bottom-10 right-20 w-40 h-40 rounded-full pointer-events-none" style="background: rgba(241, 154, 120, .2); filter: blur(40px);"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold mb-2.5 border"
                         style="background: rgba(255,255,255,0.85); border-color: rgba(141, 201, 226, 0.4); color: var(--brand-dark)">
                        <span class="w-2 h-2 rounded-full" style="background: var(--brand)"></span>
                        <span>Módulo de Pacientes</span>
                    </div>

                    <h1 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight" style="color: var(--navy)">
                        Mascotas Registradas
                    </h1>
                    <p class="text-xs sm:text-sm mt-1 max-w-lg leading-relaxed" style="color: #4A637B">
                        @if ($rolId === 4)
                            Consulta la información, estado de salud y fichas clínicas de tus mascotas.
                        @else
                            Directorio general de pacientes caninos, felinos y otras especies atendidas en la clínica.
                        @endif
                    </p>
                </div>

                @if (in_array($rolId, [3, 4]))
                    <a href="/mascota/crear"
                       class="btn-3d px-5 py-3 text-sm font-semibold rounded-2xl inline-flex items-center justify-center gap-2 shadow-md shrink-0 self-start sm:self-auto cursor-pointer">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Registrar mascota</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Barra de Búsqueda y Filtros -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <form method="GET" action="/mascota" class="relative flex-1 max-w-md">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="busqueda" value="{{ $termino }}"
                       placeholder="Buscar por nombre o especie (ej. Luna, Perro)..."
                       class="w-full pl-10 pr-20 py-2.5 text-sm rounded-2xl border transition-all duration-200 shadow-xs"
                       style="background: #ffffff; border-color: var(--line); color: var(--ink)">
                @if ($termino !== '')
                    <a href="/mascota" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400 hover:text-slate-600">
                        Limpiar
                    </a>
                @endif
            </form>

            <div class="text-xs font-semibold text-slate-500 self-center sm:self-auto">
                Total encontrados: <span class="font-bold" style="color: var(--navy)">{{ $mascotas->total() }}</span>
            </div>
        </div>

        <!-- Tabla / Directorio de Mascotas con Estilo 3D -->
        <div class="rounded-[24px] bg-white border overflow-hidden shadow-xs" style="border-color: var(--line)">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b text-xs font-bold uppercase tracking-wider"
                            style="background: linear-gradient(90deg, rgba(233,246,251,0.8), rgba(255,255,255,0.7)); border-color: var(--line); color: var(--brand-dark)">
                            <th class="py-3.5 px-5">Paciente</th>
                            <th class="py-3.5 px-4">Especie & Raza</th>
                            <th class="py-3.5 px-4">Sexo & Peso</th>
                            <th class="py-3.5 px-4">Dueño</th>
                            <th class="py-3.5 px-4">Estado de Salud</th>
                            <th class="py-3.5 px-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(215, 234, 243, 0.6)">
                        @forelse ($mascotas as $mascota)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <!-- Paciente / Nombre con Avatar -->
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-lg shrink-0 border shadow-2xs group-hover:scale-105 transition-transform"
                                             style="background: {{ strtolower($mascota->especie) === 'gato' ? '#fff0e9' : 'var(--soft)' }}; border-color: rgba(141, 201, 226, 0.3);">
                                            @if (strtolower($mascota->especie) === 'gato')
                                                🐈
                                            @elseif (strtolower($mascota->especie) === 'perro')
                                                🐕
                                            @else
                                                🐾
                                            @endif
                                        </div>
                                        <div>
                                            <a href="/mascota/ver/{{ $mascota->id }}"
                                               class="font-bold text-sm hover:underline block leading-tight" style="color: var(--navy)">
                                                {{ $mascota->nombre }}
                                            </a>
                                            <span class="text-[11px] text-slate-400">ID #{{ $mascota->id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Especie y Raza (Corregido) -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="font-semibold block text-slate-700">{{ $mascota->especie }}</span>
                                    <span class="text-xs text-slate-400">{{ $mascota->raza }}</span>
                                </td>

                                <!-- Sexo y Peso -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="text-xs font-semibold block text-slate-700">{{ $mascota->sexo }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $mascota->peso }} kg</span>
                                </td>

                                <!-- Dueño (Corregido) -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 text-xs text-slate-700">
                                        <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span class="font-medium">{{ $mascota->dueno->nombre ?? 'N/A' }}</span>
                                    </div>
                                    @if ($mascota->dueno && $mascota->dueno->telefono)
                                        <span class="text-[11px] text-slate-400 ml-5 block">{{ $mascota->dueno->telefono }}</span>
                                    @endif
                                </td>

                                <!-- Estado de Salud -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if ($mascota->estado_salud === 'al_dia')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Al día
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pendiente atención
                                        </span>
                                    @endif
                                </td>

                                <!-- Acciones -->
                                <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="/mascota/ver/{{ $mascota->id }}"
                                           class="p-1.5 rounded-xl text-slate-400 hover:text-[var(--brand)] hover:bg-[var(--soft)] transition-colors"
                                           title="Ver ficha completa">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>

                                        @if (in_array($rolId, [3, 4]))
                                            <a href="/mascota/editar/{{ $mascota->id }}"
                                               class="p-1.5 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors"
                                               title="Editar información">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>

                                            <form method="POST" action="/mascota/baja/{{ $mascota->id }}" class="inline"
                                                  onsubmit="return confirm('¿Confirmas que deseas dar de baja a {{ $mascota->nombre }}?')">
                                                @csrf
                                                <button type="submit"
                                                        class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                                                        title="Dar de baja">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center mb-3" style="background: var(--soft); color: var(--brand)">
                                        <i data-lucide="search-x" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-bold text-sm" style="color: var(--navy)">No se encontraron mascotas</p>
                                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                                        @if ($termino !== '')
                                            No hay resultados para "{{ $termino }}". Intenta con otro término.
                                        @else
                                            Aún no hay pacientes activos registrados en este listado.
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if ($mascotas->hasPages())
                <div class="p-4 border-t" style="border-color: var(--line)">
                    {{ $mascotas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection