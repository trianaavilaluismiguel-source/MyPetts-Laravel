@extends('layouts.auth')

@section('titulo', 'Panel')

@section('contenido')
    <div class="dashboard-shell p-5 sm:p-7 lg:p-8">
        <div class="dashboard-hero p-5 sm:p-7 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight" style="color:var(--ink)">Hola, {{ $usuario->nombre }}</h1>
            <p class="mt-2 text-sm" style="color:var(--muted)">Esto es lo que tienes hoy en MyPetts.</p>
        </div>

        @if ($avisosFallidos->isNotEmpty())
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 shadow-sm">
                <p class="font-medium mb-1">Algunos avisos por correo no se pudieron enviar:</p>
                <ul class="list-disc list-inside">
                    @foreach ($avisosFallidos as $aviso)
                        <li>{{ $aviso->mensaje }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (in_array($rolId, [1, 3]))
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <div class="dashboard-stat p-5">
                    <p class="text-xs font-medium uppercase tracking-[0.12em]" style="color:var(--muted)">Mascotas activas</p>
                    <p class="mt-3 text-3xl font-bold" style="color:var(--blue-deep)">{{ $totalMascotas }}</p>
                </div>
                <div class="dashboard-stat p-5">
                    <p class="text-xs font-medium uppercase tracking-[0.12em]" style="color:var(--muted)">Usuarios registrados</p>
                    <p class="mt-3 text-3xl font-bold" style="color:var(--blue-deep)">{{ $totalUsuarios }}</p>
                </div>
            </div>
        @endif

        @if ($rolId === 4)
            <div class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold" style="color:var(--ink)">Mis mascotas</h2>
                    <a href="/mascota" class="text-sm font-medium hover:underline" style="color:var(--brand-dark)">Ver todas</a>
                </div>

                @if ($mascotas->isEmpty())
                    <div class="dashboard-card p-4 text-sm" style="color:var(--muted)">Aún no tienes mascotas registradas.</div>
                @else
                    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach ($mascotas as $mascota)
                            <a href="/mascota/ver/{{ $mascota->id }}" class="dashboard-card p-4 flex items-center gap-3 hover:-translate-y-0.5 transition-transform duration-150">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl dashboard-pill">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM13.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM8.25 6.375a2.625 2.625 0 115.25 0 2.625 2.625 0 01-5.25 0zM6 19.5c0-2.485 2.686-4.5 6-4.5s6 2.015 6 4.5" />
                                    </svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="block font-semibold truncate" style="color:var(--ink)">{{ $mascota->nombre }}</span>
                                    <span class="block text-xs" style="color:var(--muted)">{{ $mascota->especie }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-semibold" style="color:var(--ink)">Próximas citas</h2>
                <a href="/cita" class="text-sm font-medium hover:underline" style="color:var(--brand-dark)">Ver todas</a>
            </div>

            <div class="space-y-3">
                @forelse ($citas as $cita)
                    <div class="dashboard-appointment flex items-center gap-4 p-4">
                        <div class="dashboard-pill flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-2xl text-center">
                            <span class="text-[10px] font-bold uppercase leading-none">{{ $cita->fecha->format('M') }}</span>
                            <span class="mt-1 text-sm font-bold leading-none">{{ $cita->fecha->format('d') }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium" style="color:var(--ink)">
                                {{ \Illuminate\Support\Carbon::parse($cita->hora)->format('h:i A') }}
                                @if ($rolId === 4)
                                    con {{ $cita->veterinario->nombre ?? 'N/A' }}
                                @elseif ($rolId === 2)
                                    — {{ $cita->mascota->nombre ?? 'N/A' }}
                                @else
                                    — {{ $cita->mascota->nombre ?? 'N/A' }} ({{ $cita->veterinario->nombre ?? 'N/A' }})
                                @endif
                            </p>
                            <p class="text-xs" style="color:var(--muted)">{{ $cita->tipo_consulta }}</p>
                        </div>
                    </div>
                @empty
                    <div class="dashboard-card p-4 text-sm" style="color:var(--muted)">No hay citas próximas.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection