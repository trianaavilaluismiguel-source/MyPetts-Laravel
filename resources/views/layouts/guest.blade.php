<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') - MyPetts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen page-enter flex items-center justify-center p-4 sm:p-8" style="background:var(--soft)">
    <div class="w-full max-w-5xl grid lg:grid-cols-2 rounded-3xl overflow-hidden reveal" style="background:var(--surface); box-shadow:var(--shadow)">

        <!-- Panel de bienvenida -->
        <div class="hidden lg:flex relative flex-col justify-between p-10 overflow-hidden" style="background:linear-gradient(150deg, #dff4fa, #f2fbfd 62%, #fff7f2);">
            <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full" style="background:rgba(141, 201, 226, .25)"></div>
            <div class="absolute -bottom-20 -left-16 w-64 h-64 rounded-full" style="background:rgba(241, 154, 120, .13)"></div>

            <div class="relative">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold" style="background:rgba(255,255,255,.8); color:var(--brand-dark)">
                    <span class="w-2 h-2 rounded-full" style="background:var(--accent)"></span>
                    Todo bajo control
                </div>
                <h2 class="font-display text-3xl font-bold tracking-tight mt-6 leading-tight" style="color:var(--ink)">Una rutina más<br><span style="color:var(--brand-dark)">tranquila y clara.</span></h2>
                <p class="text-sm mt-3 max-w-xs leading-6" style="color:var(--muted)">Organiza cada detalle del cuidado de tus mascotas desde un solo lugar.</p>
            </div>

            <div class="relative space-y-3 mt-10">
                <div class="bg-white/85 rounded-2xl p-4 border border-white shadow-sm flex items-center justify-between">
                    <div><p class="text-xs font-semibold" style="color:var(--brand)">PRÓXIMA CITA</p><p class="font-semibold mt-1" style="color:var(--ink)">Control general · Rex</p></div>
                    <span class="text-xs font-semibold rounded-lg px-2.5 py-1.5" style="background:var(--soft); color:var(--brand-dark)">Mañana</span>
                </div>
                <div class="bg-white/85 rounded-2xl p-4 border border-white shadow-sm flex items-center justify-between">
                    <div><p class="text-xs font-semibold" style="color:var(--accent)">VACUNA</p><p class="font-semibold mt-1" style="color:var(--ink)">Antirrábica · Luna</p></div>
                    <span class="text-xs font-semibold rounded-lg px-2.5 py-1.5" style="background:#fff0e9; color:#c56b4f">En 6 días</span>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="flex flex-col justify-center p-8 sm:p-12">
            <div class="flex items-center gap-2 mb-8">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-2xl btn-3d text-sm font-bold font-display">M</span>
                <span class="font-display font-semibold tracking-tight text-lg" style="color:var(--navy)">MyPetts</span>
            </div>

            @if (session('mensaje'))
                <div class="mb-4 rounded-xl text-sm px-4 py-3" style="background:var(--soft); color:var(--brand-dark)">
                    {{ session('mensaje') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-xl bg-white text-sm px-4 py-3 border border-red-200" style="color:#B42318">
                    {{ session('error') }}
                </div>
            @endif

            @yield('contenido')
        </div>
    </div>
</body>
</html>