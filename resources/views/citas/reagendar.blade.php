@extends('layouts.auth')

@section('titulo', 'Reagendar Cita')

@section('contenido')
    <div class="space-y-6 max-w-xl">
        <!-- Top bar de navegación -->
        <div class="flex items-center justify-between">
            <a href="/cita" class="inline-flex items-center gap-2 text-xs font-semibold px-3.5 py-2 rounded-full transition-all group border shadow-2xs"
               style="background: #ffffff; border-color: var(--line); color: var(--navy)">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver a citas</span>
            </a>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full text-amber-800 bg-amber-50 border border-amber-200/60">
                <i data-lucide="calendar-clock" class="w-3.5 h-3.5 text-amber-600"></i>
                Reprogramación
            </span>
        </div>

        <!-- Tarjeta de Cita Actual -->
        <div class="p-4 rounded-2xl border flex items-center justify-between"
             style="background: var(--soft); border-color: rgba(67, 143, 194, 0.25);">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white border border-sky-200 flex items-center justify-center text-sky-700">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Cita Programada Actualmente</span>
                    <p class="text-sm font-bold" style="color: var(--navy)">
                        {{ $cita->fecha->format('d/m/Y') }} a las {{ \Illuminate\Support\Carbon::parse($cita->hora)->format('h:i A') }}
                    </p>
                    <span class="text-xs text-slate-500 font-medium">Paciente: {{ $cita->mascota->nombre ?? 'N/A' }} · Dr. {{ $cita->veterinario->nombre ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Sugerencias de Horarios cuando hay colisión -->
        @if (session('sugerencias'))
            <div class="rounded-2xl border border-amber-200 bg-amber-50/90 p-4 text-sm text-amber-900 shadow-xs flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
                <div class="flex-1">
                    <p class="font-bold text-xs uppercase tracking-wider text-amber-800">El horario elegido no está disponible</p>
                    <p class="text-xs text-amber-700 mt-0.5">Horarios libres cercanos con el Dr(a). {{ $cita->veterinario->nombre ?? '' }}:</p>
                    <div class="flex flex-wrap gap-2 mt-2.5">
                        @foreach (session('sugerencias') as $s)
                            <button type="button"
                                    onclick="seleccionarSugerencia('{{ $s['fecha'] }}', '{{ $s['hora'] }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-amber-300 text-xs font-bold text-amber-900 hover:bg-amber-100 transition-colors shadow-2xs cursor-pointer">
                                <i data-lucide="clock" class="w-3 h-3 text-amber-600"></i>
                                <span>{{ \Illuminate\Support\Carbon::parse($s['fecha'])->format('d/m') }} - {{ \Illuminate\Support\Carbon::parse($s['hora'])->format('h:i A') }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Tarjeta de Formulario de Reagendamiento -->
        <div class="rounded-[28px] bg-white border p-6 sm:p-8 shadow-xs relative overflow-hidden"
             style="border-color: var(--line)">

            <div class="mb-6 pb-5 border-b" style="border-color: rgba(215, 234, 243, 0.6)">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-2" style="background: rgba(67, 143, 194, 0.08); border: 1px solid rgba(67, 143, 194, 0.18);">
                    <span class="w-2 h-2 rounded-full" style="background: var(--accent)"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[.14em]" style="color: var(--brand-dark)">Nuevo Horario</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight" style="color: var(--navy)">Elegir Nueva Fecha y Hora</h1>
                <p class="text-xs text-slate-500 mt-1">Selecciona la nueva fecha para trasladar la cita de {{ $cita->mascota->nombre ?? 'tu mascota' }}.</p>
            </div>

            <form method="POST" action="/cita/reagendar/{{ $cita->id }}" class="space-y-4">
                @csrf

                <!-- Fecha y Hora en 2 Columnas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="fecha" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Nueva fecha
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </span>
                            <input id="fecha" type="date" name="fecha" value="{{ old('fecha', $cita->fecha->format('Y-m-d')) }}"
                                   min="{{ now()->toDateString() }}" required autofocus
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                   style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                        </div>
                        @error('fecha')
                            <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="hora" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Nuevo horario
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </span>
                            <select id="hora" name="hora" required
                                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                    style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                                <option value="">Selecciona horario...</option>
                                @foreach ($horasDisponibles as $hora)
                                    <option value="{{ $hora }}" @selected(old('hora', $cita->hora) === $hora)>
                                        {{ \Illuminate\Support\Carbon::parse($hora)->format('h:i A') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('hora')
                            <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center gap-3 pt-4 border-t" style="border-color: rgba(215, 234, 243, 0.6)">
                    <button type="submit" class="btn-3d px-6 py-3 text-sm font-semibold rounded-xl flex items-center gap-2 cursor-pointer shadow-md">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                        <span>Confirmar reagendamiento</span>
                    </button>
                    <a href="/cita" class="btn-3d-ghost px-5 py-3 text-sm font-semibold rounded-xl">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function seleccionarSugerencia(fecha, hora) {
            const inputFecha = document.getElementById('fecha');
            const selectHora = document.getElementById('hora');
            if (inputFecha && selectHora) {
                inputFecha.value = fecha;
                selectHora.value = hora;
                inputFecha.classList.add('ring-2', 'ring-emerald-400');
                selectHora.classList.add('ring-2', 'ring-emerald-400');
                setTimeout(() => {
                    inputFecha.classList.remove('ring-2', 'ring-emerald-400');
                    selectHora.classList.remove('ring-2', 'ring-emerald-400');
                }, 700);
            }
        }
    </script>
@endsection