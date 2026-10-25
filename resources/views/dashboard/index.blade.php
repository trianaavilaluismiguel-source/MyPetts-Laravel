@extends('layouts.auth')

@section('titulo', 'Panel Principal')

@section('contenido')
    <div class="space-y-8">
        <!-- Hero Banner del Dashboard (Estilo Welcome) -->
        <div class="relative overflow-hidden rounded-[32px] p-6 sm:p-10 border shadow-sm"
             style="background: linear-gradient(135deg, #dff4fa, #f2fbfd 50%, #fff4ec); border-color: rgba(166, 208, 228, 0.7);">

            <!-- Esferas decorativas de fondo -->
            <div class="absolute -right-10 -top-10 w-52 h-52 rounded-full pointer-events-none" style="background: rgba(141, 201, 226, .35); filter: blur(40px);"></div>
            <div class="absolute -bottom-12 -left-10 w-60 h-60 rounded-full pointer-events-none" style="background: rgba(241, 154, 120, .2); filter: blur(50px);"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <!-- Badge del rol -->
                    <div class="inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-xs font-bold mb-3 border shadow-xs"
                         style="background: rgba(255,255,255,0.9); border-color: rgba(141, 201, 226, 0.5); color: var(--brand-dark)">
                        <span class="w-2 h-2 rounded-full animate-ping" style="background: var(--accent)"></span>
                        @if ($rolId === 1)
                            <span>🛡️ Panel Administrativo</span>
                        @elseif ($rolId === 2)
                            <span>🩺 Espacio Veterinario Clínico</span>
                        @elseif ($rolId === 3)
                            <span>📋 Gestión y Recepción</span>
                        @else
                            <span>🐾 Portal del Dueño de Mascota</span>
                        @endif
                    </div>

                    <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight" style="color: var(--navy)">
                        ¡Hola, <span style="color: var(--blue-deep)">{{ $usuario->nombre }}</span>!
                    </h1>
                    <p class="text-sm sm:text-base mt-2 max-w-xl leading-relaxed" style="color: #4A637B">
                        @if ($rolId === 1)
                            Monitorea las métricas generales de la clínica, actividad de pacientes y administración de usuarios.
                        @elseif ($rolId === 2)
                            Revisa tus consultas programadas, atiende pacientes y lleva el registro clínico de hoy.
                        @elseif ($rolId === 3)
                            Organiza la agenda del día, recepciona pacientes y coordina las visitas a la veterinaria.
                        @else
                            Todo sobre la salud, citas médicas y vacunas de tus compañeros en un solo lugar.
                        @endif
                    </p>
                </div>

                <!-- Botones de Acción Rápida según el Rol -->
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    @if (in_array($rolId, [3, 4]))
                        <a href="/cita/crear" class="btn-3d px-5 py-3 text-sm font-semibold rounded-2xl flex items-center gap-2 shadow-md">
                            <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                            <span>Agendar Cita</span>
                        </a>
                        <a href="/mascota/crear" class="btn-3d-ghost px-5 py-3 text-sm font-semibold rounded-2xl flex items-center gap-2 bg-white">
                            <i data-lucide="plus-circle" class="w-4 h-4" style="color: var(--brand)"></i>
                            <span>Registrar Mascota</span>
                        </a>
                    @elseif ($rolId === 2)
                        <a href="/cita" class="btn-3d px-5 py-3 text-sm font-semibold rounded-2xl flex items-center gap-2 shadow-md">
                            <i data-lucide="stethoscope" class="w-4 h-4"></i>
                            <span>Ver Pacientes de Hoy</span>
                        </a>
                        <a href="/reporte" class="btn-3d-ghost px-5 py-3 text-sm font-semibold rounded-2xl flex items-center gap-2 bg-white">
                            <i data-lucide="file-text" class="w-4 h-4" style="color: var(--brand)"></i>
                            <span>Reporte Clínico</span>
                        </a>
                    @elseif ($rolId === 1)
                        <a href="/usuario/crear" class="btn-3d px-5 py-3 text-sm font-semibold rounded-2xl flex items-center gap-2 shadow-md">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            <span>Nuevo Usuario</span>
                        </a>
                        <a href="/estadisticas" class="btn-3d-ghost px-5 py-3 text-sm font-semibold rounded-2xl flex items-center gap-2 bg-white">
                            <i data-lucide="pie-chart" class="w-4 h-4" style="color: var(--brand)"></i>
                            <span>Estadísticas</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alertas de Avisos Fallidos -->
        @if ($avisosFallidos->isNotEmpty())
            <div class="rounded-2xl border border-amber-200 bg-amber-50/80 p-4 text-sm text-amber-900 shadow-xs flex items-start gap-3">
                <i data-lucide="bell-ring" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-bold">Avisos pendientes de notificación:</p>
                    <ul class="list-disc list-inside mt-1 space-y-0.5 text-xs text-amber-800">
                        @foreach ($avisosFallidos as $aviso)
                            <li>{{ $aviso->mensaje }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- TARJETAS DE MÉTRICAS (KPIs) PARA ADMIN Y RECEPCIÓN -->
        @if (in_array($rolId, [1, 3]))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Tarjeta 1: Mascotas Activas -->
                <div class="p-6 rounded-[24px] bg-white border shadow-xs hover:shadow-md transition-shadow relative overflow-hidden"
                     style="border-color: var(--line)">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Mascotas en Sistema</span>
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background: var(--soft); color: var(--brand)">
                            <i data-lucide="paw-print" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold font-display" style="color: var(--navy)">{{ $totalMascotas }}</p>
                    <div class="mt-2 flex items-center gap-1.5 text-xs text-emerald-600 font-semibold">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        <span>Pacientes activos</span>
                    </div>
                </div>

                <!-- Tarjeta 2: Usuarios Registrados -->
                <div class="p-6 rounded-[24px] bg-white border shadow-xs hover:shadow-md transition-shadow relative overflow-hidden"
                     style="border-color: var(--line)">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Usuarios Totales</span>
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center bg-indigo-50 text-indigo-600">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold font-display" style="color: var(--navy)">{{ $totalUsuarios }}</p>
                    <div class="mt-2 flex items-center gap-1.5 text-xs text-indigo-600 font-semibold">
                        <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                        <span>Personal y dueños</span>
                    </div>
                </div>

                <!-- Tarjeta 3: Citas Pendientes de Atención -->
                <div class="p-6 rounded-[24px] bg-white border shadow-xs hover:shadow-md transition-shadow relative overflow-hidden"
                     style="border-color: var(--line)">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Citas en Agenda</span>
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center bg-amber-50 text-amber-600">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold font-display" style="color: var(--navy)">{{ $citas->count() }}</p>
                    <div class="mt-2 flex items-center gap-1.5 text-xs text-amber-700 font-semibold">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        <span>Próximas citas</span>
                    </div>
                </div>

                <!-- Tarjeta 4: Enlace a Reportes o Estadísticas -->
                <div class="p-6 rounded-[24px] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-md relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-300">Resumen y Exportación</span>
                        <p class="text-base font-bold mt-1 text-white">Descargar informes</p>
                        <p class="text-xs text-slate-400 mt-1">Genera reportes en formato PDF y Excel al instante.</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-700/60 flex items-center justify-between">
                        <a href="/reporte" class="text-xs font-bold text-sky-400 hover:text-sky-300 flex items-center gap-1">
                            <span>Ir a reportes</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                        <i data-lucide="file-spreadsheet" class="w-5 h-5 text-slate-500"></i>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- SECCIÓN: MIS MASCOTAS (SOLO DUEÑO DE MASCOTA) -->
            @if ($rolId === 4)
                <div class="lg:col-span-7 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background: var(--soft); color: var(--brand)">
                                <i data-lucide="dog" class="w-4 h-4"></i>
                            </div>
                            <h2 class="text-lg font-bold font-display" style="color: var(--navy)">Mis Mascotas</h2>
                        </div>
                        <a href="/mascota" class="text-xs font-bold hover:underline flex items-center gap-1" style="color: var(--brand-dark)">
                            <span>Ver todas ({{ $mascotas->count() }})</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>

                    @if ($mascotas->isEmpty())
                        <div class="p-8 text-center rounded-[28px] border bg-white" style="border-color: var(--line)">
                            <div class="w-14 h-14 mx-auto rounded-3xl flex items-center justify-center mb-3" style="background: var(--soft); color: var(--brand)">
                                <i data-lucide="paw-print" class="w-7 h-7"></i>
                            </div>
                            <h3 class="font-bold text-base" style="color: var(--navy)">Aún no tienes mascotas registradas</h3>
                            <p class="text-xs text-slate-500 max-w-xs mx-auto mt-1 mb-5">
                                Registra a tu perro, gato u otra mascota para empezar a llevar su ficha médica y vacunas.
                            </p>
                            <a href="/mascota/crear" class="btn-3d px-5 py-2.5 text-xs font-semibold rounded-xl inline-flex items-center gap-2">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                <span>Registrar mi primera mascota</span>
                            </a>
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach ($mascotas as $mascota)
                                <a href="/mascota/ver/{{ $mascota->id }}"
                                   class="p-4 rounded-[22px] bg-white border hover:border-[var(--brand)] shadow-xs hover:shadow-md transition-all group flex items-start justify-between"
                                   style="border-color: var(--line)">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shrink-0 transition-transform group-hover:scale-105"
                                             style="background: {{ strtolower($mascota->especie) === 'gato' ? '#fff0e9' : 'var(--soft)' }}; color: {{ strtolower($mascota->especie) === 'gato' ? 'var(--accent)' : 'var(--brand)' }}">
                                            @if (strtolower($mascota->especie) === 'gato')
                                                🐈
                                            @elseif (strtolower($mascota->especie) === 'perro')
                                                🐕
                                            @else
                                                🐾
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-bold text-sm truncate" style="color: var(--navy)">{{ $mascota->nombre }}</h4>
                                            <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $mascota->especie }} · {{ $mascota->raza }}</p>
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $mascota->estado_salud === 'al_dia' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $mascota->estado_salud === 'al_dia' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                                    {{ $mascota->estado_salud === 'al_dia' ? 'Al día' : 'Pendiente atención' }}
                                                </span>
                                                <span class="text-[10px] text-slate-400 font-medium">{{ $mascota->peso }} kg</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-slate-300 group-hover:text-[var(--brand)] transition-colors">
                                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <!-- SECCIÓN: PRÓXIMAS CITAS (PARA TODOS LOS ROLES) -->
            <div class="{{ $rolId === 4 ? 'lg:col-span-5' : 'lg:col-span-7' }} space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-sky-50 text-sky-700">
                            <i data-lucide="calendar-check" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-lg font-bold font-display" style="color: var(--navy)">Próximas Citas Médicas</h2>
                    </div>
                    <a href="/cita" class="text-xs font-bold hover:underline flex items-center gap-1" style="color: var(--brand-dark)">
                        <span>Ver agenda</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse ($citas as $cita)
                        <div class="p-4 rounded-[22px] bg-white border shadow-xs hover:shadow-md transition-all flex items-center justify-between gap-4"
                             style="border-color: var(--line)">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <!-- Badge de Fecha Calendario -->
                                <div class="flex flex-col items-center justify-center w-12 h-13 rounded-2xl text-center shrink-0 border"
                                     style="background: var(--soft); border-color: rgba(67, 143, 194, 0.25);">
                                    <span class="text-[9px] font-extrabold uppercase leading-none" style="color: var(--brand-dark)">
                                        {{ $cita->fecha->format('M') }}
                                    </span>
                                    <span class="text-base font-extrabold leading-tight mt-0.5" style="color: var(--navy)">
                                        {{ $cita->fecha->format('d') }}
                                    </span>
                                </div>

                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold" style="color: var(--navy)">
                                            {{ \Illuminate\Support\Carbon::parse($cita->hora)->format('h:i A') }}
                                        </span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                                            {{ $cita->tipo_consulta }}
                                        </span>
                                    </div>

                                    <p class="text-xs text-slate-600 font-semibold mt-1 truncate">
                                        @if ($rolId === 4)
                                            Mascota: <strong style="color: var(--navy)">{{ $cita->mascota->nombre ?? 'N/A' }}</strong> · Dr. {{ $cita->veterinario->nombre ?? 'N/A' }}
                                        @elseif ($rolId === 2)
                                            Paciente: <strong style="color: var(--navy)">{{ $cita->mascota->nombre ?? 'N/A' }}</strong> ({{ $cita->mascota->especie ?? 'N/A' }})
                                        @else
                                            Paciente: <strong style="color: var(--navy)">{{ $cita->mascota->nombre ?? 'N/A' }}</strong> · Vet: {{ $cita->veterinario->nombre ?? 'N/A' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Botón contextual según rol -->
                            <div class="shrink-0">
                                @if ($rolId === 2)
                                    <form method="POST" action="/cita/atender/{{ $cita->id }}">
                                        @csrf
                                        <button type="submit" class="btn-3d px-3 py-1.5 text-xs font-semibold rounded-xl flex items-center gap-1.5 cursor-pointer">
                                            <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i>
                                            <span>Atender</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Agendada
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center rounded-[24px] border bg-white" style="border-color: var(--line)">
                            <div class="w-10 h-10 mx-auto rounded-2xl flex items-center justify-center mb-2" style="background: var(--soft); color: var(--brand)">
                                <i data-lucide="calendar-x" class="w-5 h-5"></i>
                            </div>
                            <p class="text-xs font-bold" style="color: var(--navy)">No hay citas próximas programadas</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tus citas activas aparecerán aquí tan pronto sean agendadas.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SECCIÓN: ACCESOS RÁPIDOS Y AYUDA (PARA ADMIN, VET Y RECEPCIÓN) -->
            @if ($rolId !== 4)
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center bg-amber-50 text-amber-700">
                            <i data-lucide="zap" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-lg font-bold font-display" style="color: var(--navy)">Accesos Directos</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="/mascota" class="p-4 rounded-2xl bg-white border hover:border-[var(--brand)] shadow-xs transition-all flex items-center gap-3 group"
                           style="border-color: var(--line)">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-sky-50 text-sky-600 group-hover:scale-105 transition-transform">
                                <i data-lucide="dog" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold" style="color: var(--navy)">Pacientes</p>
                                <p class="text-[10px] text-slate-400">Ver directorio</p>
                            </div>
                        </a>

                        <a href="/historial/listar" class="p-4 rounded-2xl bg-white border hover:border-[var(--brand)] shadow-xs transition-all flex items-center gap-3 group"
                           style="border-color: var(--line)">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-rose-50 text-rose-600 group-hover:scale-105 transition-transform">
                                <i data-lucide="clipboard-pulse" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold" style="color: var(--navy)">Historial</p>
                                <p class="text-[10px] text-slate-400">Fichas médicas</p>
                            </div>
                        </a>

                        <a href="/vacuna/listar" class="p-4 rounded-2xl bg-white border hover:border-[var(--brand)] shadow-xs transition-all flex items-center gap-3 group"
                           style="border-color: var(--line)">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-600 group-hover:scale-105 transition-transform">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold" style="color: var(--navy)">Vacunación</p>
                                <p class="text-[10px] text-slate-400">Carnets al día</p>
                            </div>
                        </a>

                        <a href="/reporte" class="p-4 rounded-2xl bg-white border hover:border-[var(--brand)] shadow-xs transition-all flex items-center gap-3 group"
                           style="border-color: var(--line)">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-violet-50 text-violet-600 group-hover:scale-105 transition-transform">
                                <i data-lucide="file-bar-chart" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold" style="color: var(--navy)">Reportes</p>
                                <p class="text-[10px] text-slate-400">Exportar datos</p>
                            </div>
                        </a>
                    </div>

                    <!-- Tarjeta de Soporte y Recomendación -->
                    <div class="p-5 rounded-2xl border" style="background: var(--soft); border-color: rgba(67, 143, 194, 0.2);">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="info" class="w-4 h-4" style="color: var(--brand)"></i>
                            <span class="text-xs font-bold" style="color: var(--navy)">Regla Operativa</span>
                        </div>
                        <p class="text-xs leading-relaxed" style="color: #4A637B">
                            Recuerda que las entradas clínicas del historial solo pueden ser editadas por el veterinario tratante dentro de las <strong>primeras 24 horas</strong> de su registro.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection