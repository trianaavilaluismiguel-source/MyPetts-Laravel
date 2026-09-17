<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyPetts - Cuidado veterinario simple</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans page-enter">

    <header class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-2xl btn-3d text-sm font-bold font-display">M</span>
            <span class="font-display font-semibold tracking-tight text-lg" style="color:var(--navy)">MyPetts</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="/login" class="text-sm font-medium font-display" style="color:var(--blue-deep)">Iniciar sesión</a>
            <a href="/registro" class="btn-3d text-sm px-5 py-2.5">Crear cuenta</a>
        </div>
    </header>

    <main>
    <section class="max-w-6xl mx-auto px-6 pt-16 pb-24 grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <p class="text-xs font-semibold uppercase tracking-[.18em] mb-5" style="color:var(--accent)">Bienestar animal, sin complicaciones</p>
            <h1 class="font-display text-4xl sm:text-6xl font-bold tracking-tight leading-[1.04]" style="color:var(--navy)">
                El cuidado de tu mascota,
                <span style="color:var(--blue-deep)">organizado de verdad.</span>
            </h1>
            <p class="mt-6 text-lg leading-8 max-w-lg" style="color:#3A5573">
                Una forma más clara de cuidar lo importante. Centraliza citas, historial clínico, vacunas y recordatorios para que cada decisión llegue a tiempo.
            </p>
            <div class="mt-9 flex flex-wrap gap-3">
                <a href="/registro" class="btn-3d px-7 py-3.5">Empezar gratis</a>
                <a href="/login" class="btn-3d-ghost px-7 py-3.5">Ya tengo cuenta</a>
            </div>
            <p class="mt-5 text-xs" style="color:#5C7690">Un espacio sencillo para familias, veterinarios y equipos de clínica.</p>
        </div>

        <div class="relative flex items-center justify-center min-h-112 reveal" style="animation-delay:.12s">
            <div class="absolute inset-4 rounded-[2.5rem]" style="background:linear-gradient(145deg, #dff4fa, #fff4ed); border:1px solid var(--line)"></div>
            <div class="card-float absolute w-64 p-5" style="top:6%; left:0%; z-index:1;">
                <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--blue-deep)">Próxima cita</p>
                <p class="font-display font-semibold mt-1" style="color:var(--navy)">Rex · Control general</p>
                <p class="text-xs mt-1" style="color:#5C7690">Mañana, 10:30 a.m.</p>
            </div>

            <div class="card-float absolute w-64 p-5" style="bottom:4%; right:0%; z-index:1;">
                <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--blue-deep)">Vacuna próxima</p>
                <p class="font-display font-semibold mt-1" style="color:var(--navy)">Antirrábica · Luna</p>
                <p class="text-xs mt-1" style="color:#5C7690">Vence en 6 días</p>
            </div>

            <div class="relative w-48 h-48 rounded-[2.5rem] flex flex-col items-center justify-center text-center p-6" style="z-index:2; background:rgba(255,255,255,.88); border:1px solid #fff; box-shadow:var(--shadow)">
                <span class="inline-flex items-center justify-center w-16 h-16 rounded-3xl text-2xl font-display font-bold" style="background:var(--soft); color:var(--brand)">M</span>
                <p class="font-display font-semibold mt-4" style="color:var(--ink)">Todo lo importante,<br>en un vistazo.</p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 pb-20 reveal" style="animation-delay:.2s">
        <div class="grid sm:grid-cols-3 gap-4 mb-10">
            <div class="panel-3d p-5">
                <p class="text-3xl font-display font-bold" style="color:var(--brand)">01</p>
                <p class="font-semibold mt-3" style="color:var(--navy)">Todo en un vistazo</p>
                <p class="text-sm mt-1" style="color:#5C7690">La información que necesitas, sin perseguirla.</p>
            </div>
            <div class="panel-3d p-5">
                <p class="text-3xl font-display font-bold" style="color:var(--accent)">02</p>
                <p class="font-semibold mt-3" style="color:var(--navy)">Decisiones a tiempo</p>
                <p class="text-sm mt-1" style="color:#5C7690">Recordatorios claros para cada etapa.</p>
            </div>
            <div class="panel-3d p-5">
                <p class="text-3xl font-display font-bold" style="color:var(--brand)">03</p>
                <p class="font-semibold mt-3" style="color:var(--navy)">Menos administración</p>
                <p class="text-sm mt-1" style="color:#5C7690">Más tiempo para cuidar y acompañar.</p>
            </div>
        </div>
        <div class="rounded-[2.5rem] p-7 sm:p-10" style="background:linear-gradient(115deg, #dff4fa, #f9fcfd 65%, #fff3ec); border:1px solid var(--line)">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5 mb-8">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[.18em]" style="color:var(--brand-dark)">Tu centro de control</p>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold mt-2" style="color:var(--navy)">Todo lo que necesita tu mascota,<br class="hidden sm:block"> en el momento justo.</h2>
                </div>
                <p class="text-sm max-w-xs leading-6" style="color:#52718b">Una vista simple para pasar de la información a la acción.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="bg-white/80 rounded-2xl p-5 border border-white">
                    <span class="inline-flex w-8 h-8 rounded-xl items-center justify-center text-xs font-bold" style="background:var(--soft); color:var(--brand)">01</span>
                    <h3 class="font-display font-semibold mt-5" style="color:var(--navy)">Citas</h3>
                    <p class="text-sm mt-1.5 leading-5" style="color:#52718b">Agenda y reagenda sin llamadas.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-5 border border-white">
                    <span class="inline-flex w-8 h-8 rounded-xl items-center justify-center text-xs font-bold" style="background:#fff0e9; color:#d7795b">02</span>
                    <h3 class="font-display font-semibold mt-5" style="color:var(--navy)">Historial</h3>
                    <p class="text-sm mt-1.5 leading-5" style="color:#52718b">Cada consulta, siempre a mano.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-5 border border-white">
                    <span class="inline-flex w-8 h-8 rounded-xl items-center justify-center text-xs font-bold" style="background:var(--soft); color:var(--brand)">03</span>
                    <h3 class="font-display font-semibold mt-5" style="color:var(--navy)">Vacunas</h3>
                    <p class="text-sm mt-1.5 leading-5" style="color:#52718b">Alertas antes de que sean pendientes.</p>
                </div>
                <div class="bg-white/80 rounded-2xl p-5 border border-white">
                    <span class="inline-flex w-8 h-8 rounded-xl items-center justify-center text-xs font-bold" style="background:#fff0e9; color:#d7795b">04</span>
                    <h3 class="font-display font-semibold mt-5" style="color:var(--navy)">Reportes</h3>
                    <p class="text-sm mt-1.5 leading-5" style="color:#52718b">Información lista para compartir.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 pb-24 grid lg:grid-cols-[.8fr_1.2fr] gap-12 items-start">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[.18em] mb-4" style="color:var(--accent)">Una rutina más tranquila</p>
            <h2 class="font-display text-3xl sm:text-4xl font-bold leading-tight" style="color:var(--navy)">La salud de tu mascota merece un lugar propio.</h2>
            <p class="mt-5 text-sm leading-6 max-w-sm" style="color:#52718b">MyPetts convierte las tareas dispersas en una rutina que puedes entender de un vistazo.</p>
        </div>
        <div class="relative pl-8 sm:pl-12">
            <div class="absolute left-2 sm:left-5 top-3 bottom-3 w-px" style="background:var(--line)"></div>
            <div class="relative pb-8">
                <span class="absolute -left-8 sm:-left-12 top-0 w-5 h-5 rounded-full border-4" style="background:var(--brand); border-color:var(--soft)"></span>
                <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--brand)">01 · Antes de salir</p>
                <p class="font-semibold mt-2" style="color:var(--navy)">Citas con contexto</p>
                <p class="text-sm mt-1.5" style="color:#5C7690">Consulta antecedentes y próximos pasos sin cambiar de pantalla.</p>
            </div>
            <div class="relative pb-8">
                <span class="absolute -left-8 sm:-left-12 top-0 w-5 h-5 rounded-full border-4" style="background:var(--accent); border-color:#fff0e9"></span>
                <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--accent)">02 · Durante la consulta</p>
                <p class="font-semibold mt-2" style="color:var(--navy)">Historial que acompaña</p>
                <p class="text-sm mt-1.5" style="color:#5C7690">Cada diagnóstico y tratamiento queda disponible cuando lo necesitas.</p>
            </div>
            <div class="relative">
                <span class="absolute -left-8 sm:-left-12 top-0 w-5 h-5 rounded-full border-4" style="background:var(--brand); border-color:var(--soft)"></span>
                <p class="text-xs font-semibold uppercase tracking-wide" style="color:var(--brand)">03 · Después</p>
                <p class="font-semibold mt-2" style="color:var(--navy)">Alertas y reportes listos</p>
                <p class="text-sm mt-1.5" style="color:#5C7690">Vacunas visibles y datos claros para compartir con tu equipo veterinario.</p>
            </div>
        </div>
    </section>
    </main>

    <footer class="max-w-6xl mx-auto px-6 py-8">
        <p class="text-center text-sm" style="color:#5C7690">© {{ date('Y') }} MyPetts</p>
    </footer>

</body>
</html>