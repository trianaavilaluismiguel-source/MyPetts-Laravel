<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') - MyPetts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen page-enter">

    @php
        $rolIdNav = auth()->user()->rol_id ?? null;
        $navItems = [
            ['href' => '/dashboard', 'label' => 'Inicio', 'roles' => [1, 2, 3, 4],
             'icon' => 'M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 11-1.06 1.06l-.97-.97V19.5a2.25 2.25 0 01-2.25 2.25h-2.25a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75v4.5a.75.75 0 01-.75.75H6.75A2.25 2.25 0 014.5 19.5v-7.87l-.97.97a.75.75 0 01-1.06-1.06l8.69-8.69z'],
            ['href' => '/mascota', 'label' => 'Mascotas', 'roles' => [1, 2, 3, 4],
             'icon' => 'M4.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM13.5 12.75a3 3 0 116 0 3 3 0 01-6 0zM8.25 6.375a2.625 2.625 0 115.25 0 2.625 2.625 0 01-5.25 0zM6 19.5c0-2.485 2.686-4.5 6-4.5s6 2.015 6 4.5a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75z'],
            ['href' => '/cita', 'label' => 'Citas', 'roles' => [1, 2, 3, 4],
             'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0V11.25a2.25 2.25 0 012.25-2.25h13.5a2.25 2.25 0 012.25 2.25v7.5'],
            ['href' => '/historial/listar', 'label' => 'Historial', 'roles' => [1, 2, 3, 4],
             'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-1.519-3.75L15 12l-1.519 1.5m0 0L12 15l1.481-1.5M8.25 3H6.108c-1.135 0-2.098.847-2.245 1.972a12.06 12.06 0 000 3.056c.147 1.125 1.11 1.972 2.245 1.972H8.25m0-6.75v6.75m0-6.75h1.5m-1.5 6.75h1.5m5.25 6.75H6.108c-1.135 0-2.098-.847-2.245-1.972a48.108 48.108 0 010-3.056c.147-1.125 1.11-1.972 2.245-1.972H8.25'],
            ['href' => '/vacuna/listar', 'label' => 'Vacunas', 'roles' => [1, 2, 3, 4],
             'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
            ['href' => '/reporte', 'label' => 'Reportes', 'roles' => [1, 2],
             'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
            ['href' => '/usuario', 'label' => 'Usuarios', 'roles' => [1],
             'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
            ['href' => '/estadisticas', 'label' => 'Estadísticas', 'roles' => [1],
             'icon' => 'M3 13.5l4.5-4.5 4.5 4.5L21 4.5M21 4.5H15M21 4.5v6'],
        ];
    @endphp

    <div class="lg:flex lg:h-screen lg:overflow-hidden min-h-screen">

        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:w-64 lg:h-[calc(100vh-2rem)] lg:flex-col lg:shrink-0 glass-3d m-4 rounded-3xl">
            <a href="/" class="h-16 flex items-center gap-2 px-6">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-2xl btn-3d text-sm font-bold font-display">M</span>
                <span class="font-display font-bold tracking-tight" style="color:var(--navy)">MyPetts</span>
            </a>

            <nav class="flex-1 px-3 py-4 space-y-1.5">
                @foreach ($navItems as $item)
                    @if (in_array($rolIdNav, $item['roles']))
                        <a href="{{ $item['href'] }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                                  {{ request()->is(ltrim($item['href'], '/').'*') ? 'btn-3d' : 'text-(--navy) hover:bg-white/70' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="p-3">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn-3d-ghost flex w-full items-center gap-3 px-3 py-2.5 text-sm">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3" />
                        </svg>
                        Salir
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenido -->
        <div class="flex-1 flex flex-col min-w-0 lg:h-screen lg:min-h-0">
            <header class="app-header h-16 shrink-0 flex items-center justify-between px-4 sm:px-8">
                <a href="/" class="flex items-center gap-2 lg:hidden">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl btn-3d text-sm font-bold font-display">M</span>
                    <span class="font-display font-bold" style="color:var(--navy)">MyPetts</span>
                </a>
                <h1 class="hidden lg:block text-lg font-semibold font-display" style="color:var(--navy)">@yield('titulo')</h1>
                <div class="flex items-center gap-2">
                    <span class="w-9 h-9 rounded-full btn-3d text-sm font-semibold flex items-center justify-center font-display">
                        {{ strtoupper(substr(auth()->user()->nombre ?? '?', 0, 1)) }}
                    </span>
                </div>
            </header>

            <main class="app-content flex-1 min-h-0 p-4 sm:p-8 lg:overflow-y-auto">
                @if (session('mensaje'))
                    <div class="mb-6 panel-3d text-sm px-4 py-3" style="color:var(--blue-deep)">
                        {{ session('mensaje') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-2xl bg-white text-sm px-4 py-3 border border-red-200" style="color:#B42318; box-shadow:var(--shadow-light)">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('contenido')
            </main>

            <!-- Nav móvil -->
            <nav class="lg:hidden flex items-center justify-around glass-3d rounded-t-3xl py-2 mx-2 mb-2">
                @foreach (array_slice($navItems, 0, 5) as $item)
                    @if (in_array($rolIdNav, $item['roles']))
                        <a href="{{ $item['href'] }}" class="flex flex-col items-center gap-0.5 px-2 py-1 text-[11px] {{ request()->is(ltrim($item['href'], '/').'*') ? 'font-semibold' : '' }}" style="color:{{ request()->is(ltrim($item['href'], '/').'*') ? 'var(--blue-deep)' : 'var(--navy)' }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>

</body>
</html>