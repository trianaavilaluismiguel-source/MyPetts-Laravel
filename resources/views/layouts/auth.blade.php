<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') - MyPetts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen page-enter flex flex-col justify-between">

    @php
        $usuarioActual = auth()->user();
        $rolIdNav = $usuarioActual->rol_id ?? null;
        $navItems = [
            ['href' => '/dashboard', 'label' => 'Inicio', 'roles' => [1, 2, 3, 4], 'icon' => 'layout-dashboard'],
            ['href' => '/mascota', 'label' => 'Mascotas', 'roles' => [1, 2, 3, 4], 'icon' => 'dog'],
            ['href' => '/cita', 'label' => 'Citas', 'roles' => [1, 2, 3, 4], 'icon' => 'calendar-days'],
            ['href' => '/historial/listar', 'label' => 'Historial', 'roles' => [1, 2, 3, 4], 'icon' => 'clipboard-pulse'],
            ['href' => '/vacuna/listar', 'label' => 'Vacunas', 'roles' => [1, 2, 3, 4], 'icon' => 'shield-check'],
            ['href' => '/reporte', 'label' => 'Reportes', 'roles' => [1, 2], 'icon' => 'file-bar-chart'],
            ['href' => '/usuario', 'label' => 'Usuarios', 'roles' => [1], 'icon' => 'users-round'],
            ['href' => '/estadisticas', 'label' => 'Estadísticas', 'roles' => [1], 'icon' => 'trending-up'],
        ];

        $nombreRol = match((int)$rolIdNav) {
            1 => 'Administrador',
            2 => 'Veterinario',
            3 => 'Recepcionista',
            4 => 'Dueño de Mascota',
            default => 'Usuario'
        };
    @endphp

    <div class="lg:flex lg:h-screen lg:overflow-hidden min-h-screen">

        <!-- Sidebar Rediseñado -->
        <aside class="hidden lg:flex lg:w-72 lg:h-[calc(100vh-2rem)] lg:flex-col lg:shrink-0 glass-3d m-4 rounded-[28px] border relative overflow-hidden"
               style="border-color: rgba(215, 234, 243, 0.85);">

            <!-- Cabecera de Marca -->
            <div class="h-20 flex items-center justify-between px-6 border-b" style="border-color: rgba(215, 234, 243, 0.6);">
                <a href="/" class="flex items-center gap-3 group">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-2xl btn-3d text-sm font-bold font-display shadow-md transition-transform group-hover:scale-105">M</span>
                    <div>
                        <span class="font-display font-bold tracking-tight text-lg block leading-none" style="color:var(--navy)">MyPetts</span>
                        <span class="text-[11px] font-semibold text-slate-400 mt-1 block">Clínica & Cuidados</span>
                    </div>
                </a>
            </div>

            <!-- Navegación Lateral -->
            <nav class="flex-1 px-4 py-5 space-y-1.5 overflow-y-auto">
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Menú Principal</p>
                @foreach ($navItems as $item)
                    @if (in_array($rolIdNav, $item['roles']))
                        @php
                            $isActive = request()->is(ltrim($item['href'], '/').'*');
                        @endphp
                        <a href="{{ $item['href'] }}"
                           class="flex items-center gap-3 px-3.5 py-3 rounded-2xl text-sm font-semibold transition-all duration-200 group
                                  {{ $isActive ? 'btn-3d shadow-md' : 'hover:bg-white/80' }}"
                           style="{{ !$isActive ? 'color: var(--navy);' : '' }}">
                            <i data-lucide="{{ $item['icon'] }}"
                               class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110 {{ $isActive ? 'text-white' : 'text-[var(--brand)]' }}"></i>
                            <span class="flex-1">{{ $item['label'] }}</span>
                            @if ($isActive)
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            @endif
                        </a>
                    @endif
                @endforeach
            </nav>

            <!-- Perfil de usuario y Logout en Sidebar -->
            <div class="p-4 border-t" style="border-color: rgba(215, 234, 243, 0.6); background: rgba(255, 255, 255, 0.45);">
                <div class="flex items-center gap-3 mb-3 p-2 rounded-2xl bg-white/70 border border-slate-100">
                    <span class="w-10 h-10 rounded-2xl btn-3d text-sm font-bold flex items-center justify-center font-display shadow-sm">
                        {{ strtoupper(substr($usuarioActual->nombre ?? '?', 0, 1)) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold truncate" style="color: var(--navy)">{{ $usuarioActual->nombre }}</p>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-sky-800 bg-sky-100/80 px-2 py-0.5 rounded-full">
                            {{ $nombreRol }}
                        </span>
                    </div>
                </div>

                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn-3d-ghost flex w-full items-center justify-center gap-2.5 px-3 py-2.5 text-xs font-bold rounded-xl cursor-pointer">
                        <i data-lucide="log-out" class="w-4 h-4 text-slate-500"></i>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenedor Principal -->
        <div class="flex-1 flex flex-col min-w-0 lg:h-screen lg:min-h-0">
            <!-- Header Superior -->
            <header class="app-header h-20 shrink-0 flex items-center justify-between px-6 sm:px-10 border-b">
                <a href="/" class="flex items-center gap-2.5 lg:hidden">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl btn-3d text-sm font-bold font-display">M</span>
                    <span class="font-display font-bold text-lg" style="color:var(--navy)">MyPetts</span>
                </a>

                <div class="hidden lg:flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <h1 class="text-lg font-bold font-display tracking-tight" style="color:var(--navy)">@yield('titulo')</h1>
                </div>

                <!-- Barra derecha de usuario / accesos -->
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-bold" style="color: var(--navy)">{{ $usuarioActual->nombre }}</span>
                        <span class="text-[11px] text-slate-400">{{ $usuarioActual->correo }}</span>
                    </div>
                    <span class="w-10 h-10 rounded-2xl btn-3d text-sm font-bold flex items-center justify-center font-display shadow-sm">
                        {{ strtoupper(substr($usuarioActual->nombre ?? '?', 0, 1)) }}
                    </span>
                </div>
            </header>

            <!-- Contenido Principal -->
            <main class="app-content flex-1 min-h-0 p-4 sm:p-8 lg:p-10 lg:overflow-y-auto">
                @if (session('mensaje'))
                    <div class="mb-6 rounded-2xl text-sm px-4 py-3.5 flex items-center gap-3 border shadow-sm"
                         style="background: var(--soft); color: var(--brand-dark); border-color: rgba(67, 143, 194, 0.25);">
                        <i data-lucide="check-circle" class="w-4 h-4 shrink-0" style="color: var(--brand)"></i>
                        <span class="font-medium">{{ session('mensaje') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-2xl bg-red-50 text-sm px-4 py-3.5 border border-red-200 flex items-center gap-3 shadow-sm"
                         style="color: #B42318">
                        <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0 text-red-500"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('contenido')
            </main>

            <!-- Navegación Móvil Inferior -->
            <nav class="lg:hidden flex items-center justify-around glass-3d rounded-t-3xl py-2.5 px-3 mx-2 mb-2 border shadow-lg"
                 style="border-color: var(--line);">
                @foreach (array_slice($navItems, 0, 5) as $item)
                    @if (in_array($rolIdNav, $item['roles']))
                        @php
                            $isActive = request()->is(ltrim($item['href'], '/').'*');
                        @endphp
                        <a href="{{ $item['href'] }}"
                           class="flex flex-col items-center gap-1 px-3 py-1 text-[11px] font-semibold transition-colors
                                  {{ $isActive ? 'text-[var(--brand)] font-bold' : 'text-slate-500 hover:text-[var(--navy)]' }}">
                            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 {{ $isActive ? 'text-[var(--brand)]' : 'text-slate-400' }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>

</body>
</html>