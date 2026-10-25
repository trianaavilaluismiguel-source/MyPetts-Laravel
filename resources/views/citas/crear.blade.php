@extends('layouts.auth')

@section('titulo', 'Agendar Nueva Cita')

@section('contenido')
    <div class="space-y-6 max-w-2xl">
        <!-- Top bar de navegación -->
        <div class="flex items-center justify-between">
            <a href="/cita" class="inline-flex items-center gap-2 text-xs font-semibold px-3.5 py-2 rounded-full transition-all group border shadow-2xs"
               style="background: #ffffff; border-color: var(--line); color: var(--navy)">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-0.5" style="color: var(--brand)"></i>
                <span>Volver a la agenda</span>
            </a>

            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full text-sky-700 bg-sky-50 border border-sky-200/60">
                <i data-lucide="clock" class="w-3.5 h-3.5 text-sky-500"></i>
                Disponibilidad en tiempo real
            </span>
        </div>

        <!-- Sugerencias de Horarios Libres cuando hay colisión -->
        @if (session('sugerencias'))
            <div class="rounded-2xl border border-amber-200 bg-amber-50/90 p-4 text-sm text-amber-900 shadow-xs flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
                <div class="flex-1">
                    <p class="font-bold text-xs uppercase tracking-wider text-amber-800">El horario elegido está ocupado</p>
                    <p class="text-xs text-amber-700 mt-0.5">Te sugerimos los siguientes horarios libres para este veterinario:</p>
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

        <!-- Tarjeta de Formulario con Estilo Welcome -->
        <div class="rounded-[28px] bg-white border p-6 sm:p-8 shadow-xs relative overflow-hidden"
             style="border-color: var(--line)">

            <!-- Header del formulario -->
            <div class="mb-6 pb-5 border-b" style="border-color: rgba(215, 234, 243, 0.6)">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-2" style="background: rgba(67, 143, 194, 0.08); border: 1px solid rgba(67, 143, 194, 0.18);">
                    <span class="w-2 h-2 rounded-full" style="background: var(--brand)"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[.14em]" style="color: var(--brand-dark)">Programación</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight" style="color: var(--navy)">Agendar Cita Veterinaria</h1>
                <p class="text-xs text-slate-500 mt-1">Selecciona al paciente, el especialista y el horario de consulta.</p>
            </div>

            <form method="POST" action="/cita/crear" class="space-y-4">
                @csrf

                <!-- Mascota / Paciente -->
                <div class="space-y-1.5">
                    <label for="mascota_id" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Mascota / Paciente
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--brand)">
                            <i data-lucide="paw-print" class="w-4 h-4"></i>
                        </span>
                        <select id="mascota_id" name="mascota_id" required autofocus
                                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                            <option value="">Selecciona al paciente...</option>
                            @foreach ($mascotas as $mascota)
                                <option value="{{ $mascota->id }}" @selected(old('mascota_id') == $mascota->id)>
                                    {{ $mascota->nombre }} ({{ $mascota->especie }} · {{ $mascota->raza }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('mascota_id')
                        <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Veterinario Especialista -->
                <div class="space-y-1.5">
                    <label for="veterinario_id" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Veterinario Asignado
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </span>
                        <select id="veterinario_id" name="veterinario_id" required
                                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                            <option value="">Selecciona al médico veterinario...</option>
                            @foreach ($veterinarios as $veterinario)
                                <option value="{{ $veterinario->id }}" @selected(old('veterinario_id') == $veterinario->id)>
                                    Dr(a). {{ $veterinario->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('veterinario_id')
                        <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Fecha y Hora en 2 Columnas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="fecha" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                            Fecha de consulta
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </span>
                            <input id="fecha" type="date" name="fecha" value="{{ old('fecha', now()->toDateString()) }}"
                                   min="{{ now()->toDateString() }}" required
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
                            Horario disponible
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </span>
                            <select id="hora" name="hora" required
                                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                    style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                                <option value="">Selecciona horario...</option>
                                @foreach ($horasDisponibles as $h)
                                    <option value="{{ $h }}" @selected(old('hora') === $h)>
                                        {{ \Illuminate\Support\Carbon::parse($h)->format('h:i A') }}
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

                <!-- Tipo de Consulta -->
                <div class="space-y-1.5">
                    <label for="tipo_consulta" class="block text-xs font-bold uppercase tracking-wider" style="color: var(--navy)">
                        Motivo / Tipo de Consulta
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                        </span>
                        <select id="tipo_consulta" name="tipo_consulta" required
                                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border transition-all"
                                style="background: #fbfdfe; border-color: var(--line); color: var(--ink)">
                            <option value="">Selecciona tipo de consulta...</option>
                            @foreach ($tiposConsulta as $tipo)
                                <option value="{{ $tipo }}" @selected(old('tipo_consulta') === $tipo)>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('tipo_consulta')
                        <p class="text-xs font-medium text-red-600 flex items-center gap-1 mt-1">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nota informativa sobre cancelaciones -->
                <div class="p-3.5 rounded-xl border flex items-start gap-2.5 text-xs"
                     style="background: var(--soft); border-color: rgba(67, 143, 194, 0.2);">
                    <i data-lucide="shield-alert" class="w-4 h-4 text-sky-700 shrink-0 mt-0.5"></i>
                    <p class="leading-relaxed" style="color: #4A637B">
                        Las citas pueden ser canceladas o reagendadas con hasta <strong>24 horas de anticipación</strong> desde esta plataforma.
                    </p>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center gap-3 pt-4 border-t" style="border-color: rgba(215, 234, 243, 0.6)">
                    <button type="submit" class="btn-3d px-6 py-3 text-sm font-semibold rounded-xl flex items-center gap-2 cursor-pointer shadow-md">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Confirmar y agendar</span>
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