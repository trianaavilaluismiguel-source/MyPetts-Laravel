<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Acceso') - MyPetts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Hero blobs animados con la misma armonía cromática de welcome */
        .login-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: .45;
            animation: blob-float 8s ease-in-out infinite alternate;
            pointer-events: none;
        }
        .login-blob--1 { width: 380px; height: 380px; background: var(--soft); top: -10%; left: -10%; }
        .login-blob--2 { width: 320px; height: 320px; background: rgba(241,154,120,.22); bottom: -12%; right: -8%; animation-delay: 2.5s; }
        .login-blob--3 { width: 220px; height: 220px; background: rgba(141,201,226,.28); top: 35%; right: 15%; animation-delay: 4.5s; }

        @keyframes blob-float {
            0%   { transform: translate(0,0) scale(1); }
            100% { transform: translate(25px, -18px) scale(1.06); }
        }

        .floating-badge {
            animation: float-badge 3.2s ease-in-out infinite;
        }
        @keyframes float-badge {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-6px); }
        }
    </style>
</head>
<body class="min-h-screen page-enter flex items-center justify-center p-4 sm:p-8 relative overflow-hidden">
    <!-- Blobs decorativos de fondo -->
    <div class="login-blob login-blob--1"></div>
    <div class="login-blob login-blob--2"></div>
    <div class="login-blob login-blob--3"></div>

    <!-- Contenedor Principal (Tarjeta Dividida 2 Columnas) -->
    <div class="w-full max-w-5xl grid lg:grid-cols-12 rounded-[32px] overflow-hidden reveal relative z-10 border"
         style="background: var(--surface); box-shadow: var(--shadow); border-color: var(--line);">

        <!-- Panel Lateral Izquierdo (Visual e Identidad de Marca) -->
        <div class="hidden lg:flex lg:col-span-5 relative flex-col justify-between p-10 overflow-hidden"
             style="background: linear-gradient(150deg, #dff4fa, #f2fbfd 58%, #fff4ec);">

            <!-- Decoración de burbujas internas -->
            <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full" style="background: rgba(141, 201, 226, .3)"></div>
            <div class="absolute -bottom-16 -left-12 w-56 h-56 rounded-full" style="background: rgba(241, 154, 120, .18)"></div>

            <!-- Cabecera de marca -->
            <div class="relative z-10">
                <a href="{{ route('inicio') }}" class="inline-flex items-center gap-2.5 group">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-2xl btn-3d text-sm font-bold font-display shadow-md transition-transform group-hover:scale-105">M</span>
                    <span class="font-display font-bold tracking-tight text-xl" style="color:var(--navy)">MyPetts</span>
                </a>

                <div class="mt-8">
                    <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold"
                         style="background: rgba(255,255,255,.9); color: var(--brand-dark); border: 1px solid rgba(141, 201, 226, 0.4);">
                        <span class="w-2 h-2 rounded-full" style="background: var(--accent)"></span>
                        Todo bajo control
                    </div>

                    <h2 class="font-display text-3xl font-extrabold tracking-tight mt-5 leading-tight" style="color:var(--navy)">
                        El cuidado de<br>
                        <span style="color:var(--blue-deep)">tu mejor amigo,</span><br>
                        siempre al día.
                    </h2>
                    <p class="text-sm mt-3.5 leading-relaxed" style="color: #4A637B">
                        Gestiona citas veterinarias, vacunas, historial y tratamientos en una sola plataforma unificada.
                    </p>
                </div>
            </div>

            <!-- Imagen Destacada & Tarjetas Flotantes -->
            <div class="relative z-10 my-6">
                <div class="relative rounded-2xl overflow-hidden shadow-lg border-2 border-white">
                    <img src="/images/pets/golden.jpg" alt="Mascota en MyPetts" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
                </div>

                <!-- Tarjeta Flotante 1: Próxima cita -->
                <div class="card-float absolute -bottom-5 -right-3 p-3.5 flex items-center gap-3 floating-badge"
                     style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: var(--shadow-sm); border: 1px solid rgba(215, 234, 243, 0.9);">
                    <span class="inline-flex w-8 h-8 rounded-xl items-center justify-center" style="background: var(--soft); color: var(--brand)">
                        <i data-lucide="calendar-check" class="w-4 h-4"></i>
                    </span>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider" style="color: var(--brand)">Próxima cita</p>
                        <p class="text-xs font-bold" style="color: var(--navy)">Rex · Mañana 10:30</p>
                    </div>
                </div>

                <!-- Tarjeta Flotante 2: Vacuna al día -->
                <div class="card-float absolute -top-4 -left-3 p-3 flex items-center gap-2.5 floating-badge"
                     style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: var(--shadow-sm); animation-delay: .5s; border: 1px solid rgba(215, 234, 243, 0.9);">
                    <span class="inline-flex w-7 h-7 rounded-lg items-center justify-center" style="background: #fff0e9; color: var(--accent)">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                    </span>
                    <div>
                        <p class="text-[10px] font-bold" style="color: var(--navy)">Vacuna al día ✓</p>
                        <p class="text-[9px]" style="color: #6C8296">Luna · Antirrábica</p>
                    </div>
                </div>
            </div>

            <!-- Footer lateral: confianza -->
            <div class="relative z-10 pt-4 border-t" style="border-color: rgba(215, 234, 243, 0.6);">
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-1.5">
                        <span class="inline-flex w-6 h-6 rounded-full items-center justify-center text-[9px] font-bold" style="background:var(--soft); color:var(--brand); border:2px solid var(--surface)">🐕</span>
                        <span class="inline-flex w-6 h-6 rounded-full items-center justify-center text-[9px] font-bold" style="background:#fff0e9; color:var(--accent); border:2px solid var(--surface)">🐈</span>
                        <span class="inline-flex w-6 h-6 rounded-full items-center justify-center text-[9px] font-bold" style="background:var(--soft); color:var(--brand); border:2px solid var(--surface)">🐰</span>
                    </div>
                    <p class="text-xs font-medium" style="color: #4A637B">
                        <strong style="color: var(--navy)">+2,500</strong> mascotas atendidas
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulario (Columna Derecha) -->
        <div class="lg:col-span-7 flex flex-col justify-center p-8 sm:p-12 lg:p-14 bg-white relative">
            <!-- Mobile Brand Bar -->
            <div class="flex lg:hidden items-center justify-between mb-8 pb-4 border-b" style="border-color: var(--line)">
                <a href="{{ route('inicio') }}" class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl btn-3d text-xs font-bold font-display">M</span>
                    <span class="font-display font-bold tracking-tight text-lg" style="color:var(--navy)">MyPetts</span>
                </a>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background: var(--soft); color: var(--brand-dark)">
                    Veterinaria
                </span>
            </div>

            <!-- Alertas Flash -->
            @if (session('mensaje'))
                <div class="mb-6 rounded-2xl text-sm px-4 py-3 flex items-center gap-2.5 border"
                     style="background: var(--soft); color: var(--brand-dark); border-color: rgba(67,143,194,.25)">
                    <i data-lucide="check-circle" class="w-4 h-4 shrink-0" style="color: var(--brand)"></i>
                    <span>{{ session('mensaje') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl text-sm px-4 py-3 flex items-center gap-2.5 border border-red-200 bg-red-50/70"
                     style="color: #B42318">
                    <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0 text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('contenido')
        </div>
    </div>
</body>
</html>