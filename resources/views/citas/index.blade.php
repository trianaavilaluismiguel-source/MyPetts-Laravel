@extends('layouts.auth')

@section('titulo', 'Agenda de Citas')

@section('contenido')
    @php
        $rolId = (int) auth()->user()->rol_id;
    @endphp

    <div class="space-y-6">
        <!-- Banner de Encabezado Superior -->
        <div class="rounded-[28px] p-6 sm:p-8 border shadow-xs relative overflow-hidden"
             style="background: linear-gradient(135deg, #e4f5fb, #f7fcfe 55%, #fff6f0); border-color: rgba(166, 208, 228, 0.7);">

            <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full pointer-events-none" style="background: rgba(141, 201, 226, .3); filter: blur(35px);"></div>
            <div class="absolute -bottom-10 right-24 w-40 h-40 rounded-full pointer-events-none" style="background: rgba(241, 154, 120, .2); filter: blur(40px);"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold mb-2.5 border"
                         style="background: rgba(255,255,255,0.85); border-color: rgba(141, 201, 226, 0.4); color: var(--brand-dark)">
                        <span class="w-2 h-2 rounded-full" style="background: var(--brand)"></span>
                        <span>Control y Calendario</span>
                    </div>

                    <h1 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight" style="color: var(--navy)">
                        Agenda de Consultas
                    </h1>
                    <p class="text-xs sm:text-sm mt-1 max-w-lg leading-relaxed" style="color: #4A637B">
                        @if ($rolId === 4)
                            Revisa el estado de tus citas programadas, reprograma con anticipación o agenda una nueva visita.
                        @elseif ($rolId === 2)
                            Consulta tu lista de turnos clínicos asignados y atiende a los pacientes programados para hoy.
                        @else
                            Programación global de visitas, asignación de veterinarios y disponibilidad de la clínica.
                        @endif
                    </p>
                </div>

                @if (in_array($rolId, [3, 4]))
                    <a href="/cita/crear"
                       class="btn-3d px-5 py-3 text-sm font-semibold rounded-2xl inline-flex items-center justify-center gap-2 shadow-md shrink-0 self-start sm:self-auto cursor-pointer">
                        <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                        <span>Agendar nueva cita</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Tabla / Listado de Citas con Estilo 3D -->
        <div class="rounded-[24px] bg-white border overflow-hidden shadow-xs" style="border-color: var(--line)">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b text-xs font-bold uppercase tracking-wider"
                            style="background: linear-gradient(90deg, rgba(233,246,251,0.8), rgba(255,255,255,0.7)); border-color: var(--line); color: var(--brand-dark)">
                            <th class="py-3.5 px-5">Fecha & Turno</th>
                            <th class="py-3.5 px-4">Paciente</th>
                            <th class="py-3.5 px-4">Tipo de Consulta</th>
                            <th class="py-3.5 px-4">Veterinario Asignado</th>
                            <th class="py-3.5 px-4">Estado</th>
                            <th class="py-3.5 px-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(215, 234, 243, 0.6)">
                        @forelse ($citas as $cita)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <!-- Fecha y Hora con Calendario Píldora -->
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col items-center justify-center w-11 h-12 rounded-2xl text-center shrink-0 border"
                                             style="background: var(--soft); border-color: rgba(67, 143, 194, 0.25);">
                                            <span class="text-[9px] font-extrabold uppercase leading-none" style="color: var(--brand-dark)">
                                                {{ $cita->fecha->format('M') }}
                                            </span>
                                            <span class="text-sm font-extrabold leading-tight mt-0.5" style="color: var(--navy)">
                                                {{ $cita->fecha->format('d') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="font-bold text-sm block leading-tight" style="color: var(--navy)">
                                                {{ \Illuminate\Support\Carbon::parse($cita->hora)->format('h:i A') }}
                                            </span>
                                            <span class="text-[11px] text-slate-400">
                                                {{ $cita->fecha->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Mascota / Paciente con Avatar -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold border"
                                              style="background: {{ strtolower($cita->mascota->especie ?? '') === 'gato' ? '#fff0e9' : 'var(--soft)' }}; border-color: rgba(141, 201, 226, 0.3);">
                                            @if (strtolower($cita->mascota->especie ?? '') === 'gato')
                                                🐈
                                            @elseif (strtolower($cita->mascota->especie ?? '') === 'perro')
                                                🐕
                                            @else
                                                🐾
                                            @endif
                                        </span>
                                        <div>
                                            <a href="{{ $cita->mascota ? '/mascota/ver/' . $cita->mascota->id : '#' }}"
                                               class="font-bold text-sm hover:underline block leading-tight" style="color: var(--navy)">
                                                {{ $cita->mascota->nombre ?? 'N/A' }}
                                            </a>
                                            <span class="text-xs text-slate-400">{{ $cita->mascota->especie ?? 'N/A' }} · {{ $cita->mascota->raza ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Tipo de Consulta -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                                        <i data-lucide="stethoscope" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>{{ $cita->tipo_consulta ?? 'Consulta general' }}</span>
                                    </span>
                                </td>

                                <!-- Veterinario Asignado -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center text-xs font-bold">
                                            {{ strtoupper(substr($cita->veterinario->nombre ?? 'V', 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-xs block text-slate-800">
                                                Dr. {{ $cita->veterinario->nombre ?? 'N/A' }}
                                            </span>
                                            <span class="text-[10px] text-slate-400">Médico tratante</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Estado con Badges Modernos -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if ($cita->estado === 'agendada')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-sky-800 bg-sky-50 border border-sky-200/80">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                                            Agendada
                                        </span>
                                    @elseif ($cita->estado === 'completada')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200/80">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                            Completada
                                        </span>
                                    @elseif ($cita->estado === 'cancelada')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-rose-800 bg-rose-50 border border-rose-200/80">
                                            <i data-lucide="x" class="w-3.5 h-3.5 text-rose-600"></i>
                                            Cancelada
                                        </span>
                                    @elseif ($cita->estado === 'reagendada')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200/80">
                                            <i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-amber-600"></i>
                                            Reagendada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                            {{ ucfirst($cita->estado) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Acciones Contextuales -->
                                <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        @if ($cita->estado === 'agendada')
                                            <!-- Acción para Veterinario: Atender Cita -->
                                            @if ($rolId === 2 && $cita->veterinario_id === auth()->id())
                                                <form method="POST" action="/cita/atender/{{ $cita->id }}" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn-3d px-3 py-1.5 text-xs font-semibold rounded-xl flex items-center gap-1.5 cursor-pointer shadow-sm">
                                                        <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i>
                                                        <span>Atender</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Acciones para Dueño y Recepcionista: Reagendar / Cancelar -->
                                            @if (in_array($rolId, [3, 4]))
                                                <a href="/cita/reagendar/{{ $cita->id }}"
                                                   class="px-2.5 py-1 rounded-xl text-xs font-semibold text-slate-600 hover:text-[var(--brand)] hover:bg-[var(--soft)] border border-slate-200 transition-colors inline-flex items-center gap-1"
                                                   title="Reagendar fecha u hora">
                                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                                    <span>Reagendar</span>
                                                </a>

                                                <form method="POST" action="/cita/cancelar/{{ $cita->id }}" class="inline"
                                                      onsubmit="return confirm('¿Confirmas que deseas cancelar esta cita médica? (Recuerda que debe hacerse con 24h de anticipación)')">
                                                    @csrf
                                                    <button type="submit"
                                                            class="px-2.5 py-1 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-rose-200 transition-colors inline-flex items-center gap-1 cursor-pointer"
                                                            title="Cancelar cita">
                                                        <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                                                        <span>Cancelar</span>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-xs text-slate-400 italic">Finalizada</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center mb-3" style="background: var(--soft); color: var(--brand)">
                                        <i data-lucide="calendar-x" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-bold text-sm" style="color: var(--navy)">No hay citas en esta lista</p>
                                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                                        No se encontraron registros de citas para el filtro seleccionado.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if ($citas->hasPages())
                <div class="p-4 border-t" style="border-color: var(--line)">
                    {{ $citas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection