<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyPetts - Cuidado veterinario simple y organizado</title>
    <meta name="description" content="MyPetts centraliza citas, historial clínico, vacunas y recordatorios para el cuidado de tu mascota. Empieza gratis hoy.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ===== Welcome-specific styles ===== */

        /* Animated gradient background blob */
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .45;
            animation: blob-float 8s ease-in-out infinite alternate;
            pointer-events: none;
        }
        .hero-blob--1 { width: 420px; height: 420px; background: var(--soft); top: -8%; left: -6%; }
        .hero-blob--2 { width: 340px; height: 340px; background: rgba(241,154,120,.25); bottom: -10%; right: -4%; animation-delay: 2s; }
        .hero-blob--3 { width: 260px; height: 260px; background: rgba(141,201,226,.3); top: 40%; right: 20%; animation-delay: 4s; }
        @keyframes blob-float {
            0%   { transform: translate(0,0) scale(1); }
            100% { transform: translate(30px, -20px) scale(1.08); }
        }

        /* Hero image collage */
        .hero-collage { position: relative; }
        .hero-collage__img {
            border-radius: 24px;
            object-fit: cover;
            box-shadow: var(--shadow);
            border: 3px solid rgba(255,255,255,.85);
            transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease;
        }
        .hero-collage__img:hover {
            transform: scale(1.04) rotate(-1deg);
            box-shadow: 0 28px 60px rgba(57,109,139,.18);
        }

        /* Carousel */
        .carousel-track {
            display: flex;
            gap: 1.25rem;
            animation: carousel-scroll 30s linear infinite;
            width: max-content;
        }
        .carousel-track:hover { animation-play-state: paused; }
        @keyframes carousel-scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .carousel-card {
            flex: 0 0 280px;
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--line);
            transition: transform .35s ease, box-shadow .35s ease;
        }
        .carousel-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow);
        }
        .carousel-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .carousel-card__info {
            padding: 1rem 1.25rem;
            background: var(--surface);
        }

        /* Feature cards with icon */
        .feature-icon-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 2rem 1.75rem;
            box-shadow: var(--shadow-sm);
            transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease;
            position: relative;
            overflow: hidden;
        }
        .feature-icon-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--brand), var(--accent));
            border-radius: 24px 24px 0 0;
            opacity: 0;
            transition: opacity .3s ease;
        }
        .feature-icon-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow);
        }
        .feature-icon-card:hover::before { opacity: 1; }
        .feature-icon-wrap {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
        }

        /* Stats counter */
        .stat-card {
            text-align: center;
            padding: 2rem;
        }
        .stat-number {
            font-size: 2.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }

        /* Testimonial cards */
        .testimonial-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            transition: transform .35s ease, box-shadow .35s ease;
        }
        .testimonial-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
        }
        .testimonial-stars { color: #f5b942; }

        /* FAQ accordion */
        .faq-item {
            border: 1px solid var(--line);
            border-radius: 16px;
            background: var(--surface);
            overflow: hidden;
            transition: box-shadow .3s ease;
        }
        .faq-item:hover { box-shadow: var(--shadow-sm); }
        .faq-question {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            font-weight: 600;
            color: var(--ink);
            font-family: inherit;
            font-size: .95rem;
        }
        .faq-question:hover { color: var(--brand); }
        .faq-chevron {
            transition: transform .3s ease;
            color: var(--brand);
            flex-shrink: 0;
        }
        .faq-item.active .faq-chevron { transform: rotate(180deg); }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease, padding .35s ease;
            padding: 0 1.5rem;
        }
        .faq-item.active .faq-answer {
            max-height: 300px;
            padding: 0 1.5rem 1.25rem;
        }

        /* CTA section */
        .cta-section {
            background: linear-gradient(135deg, #1b4b6b, #27658f 50%, #356d94);
            border-radius: 32px;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(141,201,226,.15);
            top: -30%; right: -8%;
            pointer-events: none;
        }
        .cta-section::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(241,154,120,.1);
            bottom: -20%; left: -5%;
            pointer-events: none;
        }

        /* Floating badge */
        .floating-badge {
            animation: float-badge 3s ease-in-out infinite;
        }
        @keyframes float-badge {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }

        /* Scroll reveal stagger */
        .reveal-stagger > * {
            opacity: 0;
            transform: translateY(20px);
            animation: reveal .65s cubic-bezier(.2,.8,.2,1) both;
        }
        .reveal-stagger > *:nth-child(1) { animation-delay: .05s; }
        .reveal-stagger > *:nth-child(2) { animation-delay: .12s; }
        .reveal-stagger > *:nth-child(3) { animation-delay: .19s; }
        .reveal-stagger > *:nth-child(4) { animation-delay: .26s; }
        .reveal-stagger > *:nth-child(5) { animation-delay: .33s; }
        .reveal-stagger > *:nth-child(6) { animation-delay: .40s; }

        /* Footer links */
        .footer-link {
            color: #8aacbf;
            text-decoration: none;
            font-size: .875rem;
            transition: color .2s ease;
        }
        .footer-link:hover { color: var(--brand); }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            .hero-collage__img--main  { width: 100% !important; height: 260px !important; }
            .hero-collage__img--small { display: none; }
            .carousel-card { flex: 0 0 240px; }
            .stat-number { font-size: 2rem; }
        }
    </style>
</head>
<body class="font-sans page-enter">

    {{-- ==================== HEADER / NAV ==================== --}}
    <header class="sticky top-0 z-50" style="background: rgba(242,249,252,.78); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(215,234,243,.5)">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 group">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-2xl btn-3d text-sm font-bold font-display transition-transform group-hover:scale-105">M</span>
                <span class="font-display font-bold tracking-tight text-xl" style="color:var(--navy)">MyPetts</span>
            </a>
            <nav class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm font-medium hover:text-[var(--brand)] transition-colors" style="color:#52718b">Funciones</a>
                <a href="#gallery" class="text-sm font-medium hover:text-[var(--brand)] transition-colors" style="color:#52718b">Galería</a>
                <a href="#testimonials" class="text-sm font-medium hover:text-[var(--brand)] transition-colors" style="color:#52718b">Testimonios</a>
                <a href="#faq" class="text-sm font-medium hover:text-[var(--brand)] transition-colors" style="color:#52718b">FAQ</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="/login" class="text-sm font-semibold font-display hidden sm:inline-block" style="color:var(--blue-deep)">Iniciar sesión</a>
                <a href="/registro" class="btn-3d text-sm px-5 py-2.5 font-semibold">Crear cuenta</a>
            </div>
        </div>
    </header>

    <main>

        {{-- ==================== HERO SECTION ==================== --}}
        <section class="relative overflow-hidden">
            <div class="hero-blob hero-blob--1"></div>
            <div class="hero-blob hero-blob--2"></div>
            <div class="hero-blob hero-blob--3"></div>

            <div class="max-w-7xl mx-auto px-6 pt-20 pb-28 grid lg:grid-cols-2 gap-16 items-center relative z-10">
                {{-- Left column: text --}}
                <div class="reveal">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full mb-6" style="background: rgba(67,143,194,.08); border: 1px solid rgba(67,143,194,.18)">
                        <span class="w-2 h-2 rounded-full" style="background: var(--brand)"></span>
                        <span class="text-xs font-semibold uppercase tracking-[.16em]" style="color:var(--brand-dark)">Bienestar animal, sin complicaciones</span>
                    </div>

                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.06]" style="color:var(--navy)">
                        El cuidado de tu mascota,
                        <span class="relative">
                            <span style="color:var(--blue-deep)">organizado de verdad.</span>
                            <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 8 C60 2, 120 2, 298 8" stroke="var(--accent)" stroke-width="3" stroke-linecap="round" opacity=".6"/>
                            </svg>
                        </span>
                    </h1>

                    <p class="mt-7 text-lg leading-8 max-w-lg" style="color:#3A5573">
                        Centraliza citas, historial clínico, vacunas y recordatorios en un solo lugar. Todo lo que necesitas para que cada decisión llegue a tiempo.
                    </p>

                    <div class="mt-10 flex flex-wrap gap-4">
                        <a href="/registro" class="btn-3d px-8 py-4 text-base font-semibold flex items-center gap-2">
                            Empezar gratis
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a href="#features" class="btn-3d-ghost px-8 py-4 text-base font-semibold flex items-center gap-2">
                            <i data-lucide="play-circle" class="w-4 h-4" style="color:var(--brand)"></i>
                            Ver funciones
                        </a>
                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <div class="flex -space-x-2">
                            <span class="inline-flex w-8 h-8 rounded-full items-center justify-center text-[10px] font-bold" style="background:var(--soft); color:var(--brand); border:2px solid var(--surface)">🐕</span>
                            <span class="inline-flex w-8 h-8 rounded-full items-center justify-center text-[10px] font-bold" style="background:#fff0e9; color:var(--accent); border:2px solid var(--surface)">🐈</span>
                            <span class="inline-flex w-8 h-8 rounded-full items-center justify-center text-[10px] font-bold" style="background:var(--soft); color:var(--brand); border:2px solid var(--surface)">🐰</span>
                        </div>
                        <p class="text-sm" style="color:#5C7690">
                            <span class="font-semibold" style="color:var(--navy)">+2,500</span> familias ya confían en MyPetts
                        </p>
                    </div>
                </div>

                {{-- Right column: image collage --}}
                <div class="hero-collage reveal" style="animation-delay:.15s">
                    <div class="relative">
                        <img src="/images/pets/golden.jpg" alt="Golden Retriever en clínica veterinaria" class="hero-collage__img hero-collage__img--main w-full h-80 lg:h-96">

                        <img src="/images/pets/tabby.jpg" alt="Gato tabby descansando" class="hero-collage__img hero-collage__img--small absolute -bottom-8 -left-6 w-40 h-32 lg:w-48 lg:h-36 z-10">

                        <img src="/images/pets/vet-checkup.jpg" alt="Perrito en revisión veterinaria" class="hero-collage__img hero-collage__img--small absolute -top-6 -right-4 w-36 h-28 lg:w-44 lg:h-32 z-10">

                        {{-- Floating cards --}}
                        <div class="card-float absolute w-56 p-4 floating-badge" style="bottom:12%; right:-2%; z-index:20;">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex w-9 h-9 rounded-xl items-center justify-center" style="background:var(--soft); color:var(--brand)">
                                    <i data-lucide="calendar-check" class="w-4 h-4"></i>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold" style="color:var(--navy)">Próxima cita</p>
                                    <p class="text-[11px]" style="color:#5C7690">Rex · Mañana 10:30</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-float absolute w-52 p-4 floating-badge hidden sm:block" style="top:8%; left:-8%; z-index:20; animation-delay:.4s">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex w-9 h-9 rounded-xl items-center justify-center" style="background:#fff0e9; color:var(--accent)">
                                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold" style="color:var(--navy)">Vacuna al día</p>
                                    <p class="text-[11px]" style="color:#5C7690">Luna · Antirrábica ✓</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== TRUSTED BY / STATS ==================== --}}
        <section class="max-w-7xl mx-auto px-6 pb-16 reveal" style="animation-delay:.2s">
            <div class="rounded-[28px] p-8 sm:p-12" style="background:linear-gradient(115deg, rgba(233,246,251,.6), rgba(255,255,255,.8) 65%, rgba(255,240,233,.4)); border:1px solid var(--line)">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 reveal-stagger">
                    <div class="stat-card">
                        <p class="stat-number font-display">2.5K+</p>
                        <p class="text-sm mt-2 font-medium" style="color:#52718b">Familias activas</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-number font-display">15K+</p>
                        <p class="text-sm mt-2 font-medium" style="color:#52718b">Mascotas registradas</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-number font-display">98%</p>
                        <p class="text-sm mt-2 font-medium" style="color:#52718b">Satisfacción</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-number font-display">24/7</p>
                        <p class="text-sm mt-2 font-medium" style="color:#52718b">Acceso disponible</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== FEATURES SECTION ==================== --}}
        <section id="features" class="max-w-7xl mx-auto px-6 pb-24">
            <div class="text-center mb-14 reveal">
                <p class="text-xs font-semibold uppercase tracking-[.18em] mb-4" style="color:var(--accent)">Funciones principales</p>
                <h2 class="font-display text-3xl sm:text-4xl font-bold" style="color:var(--navy)">Todo lo que tu mascota necesita,<br class="hidden sm:block"> en un solo lugar.</h2>
                <p class="mt-5 text-base max-w-lg mx-auto leading-7" style="color:#52718b">Herramientas diseñadas para simplificar el cuidado veterinario y mantener todo bajo control.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 reveal-stagger">
                <div class="feature-icon-card">
                    <div class="feature-icon-wrap" style="background:var(--soft)">
                        <i data-lucide="calendar-days" class="w-6 h-6" style="color:var(--brand)"></i>
                    </div>
                    <h3 class="font-display font-semibold text-lg mt-5" style="color:var(--navy)">Agenda de citas</h3>
                    <p class="text-sm mt-2 leading-6" style="color:#52718b">Programa, reprograma y gestiona citas veterinarias sin complicaciones. Recibe alertas antes de cada visita.</p>
                </div>

                <div class="feature-icon-card">
                    <div class="feature-icon-wrap" style="background:#fff0e9">
                        <i data-lucide="file-text" class="w-6 h-6" style="color:var(--accent)"></i>
                    </div>
                    <h3 class="font-display font-semibold text-lg mt-5" style="color:var(--navy)">Historial clínico</h3>
                    <p class="text-sm mt-2 leading-6" style="color:#52718b">Cada consulta, diagnóstico y tratamiento queda registrado y accesible cuando lo necesitas.</p>
                </div>

                <div class="feature-icon-card">
                    <div class="feature-icon-wrap" style="background:var(--soft)">
                        <i data-lucide="syringe" class="w-6 h-6" style="color:var(--brand)"></i>
                    </div>
                    <h3 class="font-display font-semibold text-lg mt-5" style="color:var(--navy)">Control de vacunas</h3>
                    <p class="text-sm mt-2 leading-6" style="color:#52718b">Monitorea el esquema de vacunación completo. Alertas automáticas antes de cada vencimiento.</p>
                </div>

                <div class="feature-icon-card">
                    <div class="feature-icon-wrap" style="background:#fff0e9">
                        <i data-lucide="bar-chart-3" class="w-6 h-6" style="color:var(--accent)"></i>
                    </div>
                    <h3 class="font-display font-semibold text-lg mt-5" style="color:var(--navy)">Reportes y estadísticas</h3>
                    <p class="text-sm mt-2 leading-6" style="color:#52718b">Visualiza tendencias de salud, costos de atención y genera reportes para compartir con tu veterinario.</p>
                </div>

                <div class="feature-icon-card">
                    <div class="feature-icon-wrap" style="background:var(--soft)">
                        <i data-lucide="bell-ring" class="w-6 h-6" style="color:var(--brand)"></i>
                    </div>
                    <h3 class="font-display font-semibold text-lg mt-5" style="color:var(--navy)">Recordatorios inteligentes</h3>
                    <p class="text-sm mt-2 leading-6" style="color:#52718b">Nunca más olvides una cita, vacuna o tratamiento. Notificaciones claras en el momento justo.</p>
                </div>

                <div class="feature-icon-card">
                    <div class="feature-icon-wrap" style="background:#fff0e9">
                        <i data-lucide="users" class="w-6 h-6" style="color:var(--accent)"></i>
                    </div>
                    <h3 class="font-display font-semibold text-lg mt-5" style="color:var(--navy)">Múltiples mascotas</h3>
                    <p class="text-sm mt-2 leading-6" style="color:#52718b">Gestiona perfiles individuales para cada una de tus mascotas desde una sola cuenta familiar.</p>
                </div>
            </div>
        </section>

        {{-- ==================== PET GALLERY CAROUSEL ==================== --}}
        <section id="gallery" class="pb-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 mb-12 reveal">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[.18em] mb-4" style="color:var(--brand-dark)">Galería de mascotas</p>
                        <h2 class="font-display text-3xl sm:text-4xl font-bold" style="color:var(--navy)">Ellos ya son parte de MyPetts</h2>
                    </div>
                    <p class="text-sm max-w-xs leading-6" style="color:#52718b">Conoce a algunas de las mascotas que ya tienen su salud organizada.</p>
                </div>
            </div>

            <div class="relative">
                <div class="carousel-track">
                    {{-- First set --}}
                    <div class="carousel-card">
                        <img src="/images/pets/golden.jpg" alt="Max - Golden Retriever" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Max</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Golden Retriever · 3 años</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/tabby.jpg" alt="Luna - Gato Tabby" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Luna</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Gato Tabby · 2 años</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/vet-checkup.jpg" alt="Nube - Bichón Frisé" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Nube</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Bichón Frisé · 1 año</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/husky.jpg" alt="Thor - Husky Siberiano" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Thor</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Husky Siberiano · 4 años</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/corgi.jpg" alt="Coco - Corgi" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Coco</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Corgi · 1 año</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/persian.jpg" alt="Misha - Gato Persa" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Misha</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Gato Persa · 5 años</p>
                        </div>
                    </div>

                    {{-- Duplicate set for infinite scroll --}}
                    <div class="carousel-card">
                        <img src="/images/pets/golden.jpg" alt="Max - Golden Retriever" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Max</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Golden Retriever · 3 años</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/tabby.jpg" alt="Luna - Gato Tabby" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Luna</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Gato Tabby · 2 años</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/vet-checkup.jpg" alt="Nube - Bichón Frisé" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Nube</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Bichón Frisé · 1 año</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/husky.jpg" alt="Thor - Husky Siberiano" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Thor</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Husky Siberiano · 4 años</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/corgi.jpg" alt="Coco - Corgi" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Coco</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Corgi · 1 año</p>
                        </div>
                    </div>
                    <div class="carousel-card">
                        <img src="/images/pets/persian.jpg" alt="Misha - Gato Persa" loading="lazy">
                        <div class="carousel-card__info">
                            <p class="font-display font-semibold" style="color:var(--navy)">Misha</p>
                            <p class="text-xs mt-0.5" style="color:#5C7690">Gato Persa · 5 años</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== HOW IT WORKS ==================== --}}
        <section class="max-w-7xl mx-auto px-6 pb-24">
            <div class="rounded-[2.5rem] p-8 sm:p-12" style="background:linear-gradient(115deg, #dff4fa, #f9fcfd 65%, #fff3ec); border:1px solid var(--line)">
                <div class="text-center mb-12 reveal">
                    <p class="text-xs font-semibold uppercase tracking-[.18em] mb-4" style="color:var(--brand-dark)">Cómo funciona</p>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold" style="color:var(--navy)">Tres pasos para empezar</h2>
                </div>

                <div class="grid sm:grid-cols-3 gap-6 reveal-stagger">
                    <div class="bg-white/80 rounded-2xl p-7 border border-white text-center">
                        <span class="inline-flex w-14 h-14 rounded-2xl items-center justify-center mb-5" style="background:var(--soft)">
                            <i data-lucide="user-plus" class="w-6 h-6" style="color:var(--brand)"></i>
                        </span>
                        <p class="text-3xl font-display font-bold mb-2" style="color:var(--brand)">01</p>
                        <h3 class="font-display font-semibold text-lg" style="color:var(--navy)">Crea tu cuenta</h3>
                        <p class="text-sm mt-2 leading-6" style="color:#52718b">Regístrate gratis en menos de un minuto. Sin tarjeta de crédito.</p>
                    </div>

                    <div class="bg-white/80 rounded-2xl p-7 border border-white text-center">
                        <span class="inline-flex w-14 h-14 rounded-2xl items-center justify-center mb-5" style="background:#fff0e9">
                            <i data-lucide="paw-print" class="w-6 h-6" style="color:var(--accent)"></i>
                        </span>
                        <p class="text-3xl font-display font-bold mb-2" style="color:var(--accent)">02</p>
                        <h3 class="font-display font-semibold text-lg" style="color:var(--navy)">Agrega tus mascotas</h3>
                        <p class="text-sm mt-2 leading-6" style="color:#52718b">Crea perfiles con toda la información relevante de cada mascota.</p>
                    </div>

                    <div class="bg-white/80 rounded-2xl p-7 border border-white text-center">
                        <span class="inline-flex w-14 h-14 rounded-2xl items-center justify-center mb-5" style="background:var(--soft)">
                            <i data-lucide="heart-pulse" class="w-6 h-6" style="color:var(--brand)"></i>
                        </span>
                        <p class="text-3xl font-display font-bold mb-2" style="color:var(--brand)">03</p>
                        <h3 class="font-display font-semibold text-lg" style="color:var(--navy)">Organiza su cuidado</h3>
                        <p class="text-sm mt-2 leading-6" style="color:#52718b">Gestiona citas, vacunas, historial y más desde un solo lugar.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== FEATURE SHOWCASE (Image + Text) ==================== --}}
        <section class="max-w-7xl mx-auto px-6 pb-24 grid lg:grid-cols-2 gap-14 items-center">
            <div class="reveal">
                <div class="relative rounded-[2rem] overflow-hidden" style="box-shadow: var(--shadow)">
                    <img src="/images/pets/vet-checkup.jpg" alt="Veterinaria revisando mascota" class="w-full h-80 lg:h-[420px] object-cover">
                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(24,50,74,.5), transparent 60%)"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl" style="background:rgba(255,255,255,.92); backdrop-filter:blur(8px)">
                            <i data-lucide="stethoscope" class="w-4 h-4" style="color:var(--brand)"></i>
                            <span class="text-sm font-semibold" style="color:var(--navy)">Atención veterinaria organizada</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reveal" style="animation-delay:.12s">
                <p class="text-xs font-semibold uppercase tracking-[.18em] mb-4" style="color:var(--accent)">Una rutina más tranquila</p>
                <h2 class="font-display text-3xl sm:text-4xl font-bold leading-tight" style="color:var(--navy)">La salud de tu mascota merece un lugar propio.</h2>
                <p class="mt-5 text-base leading-7 max-w-md" style="color:#52718b">MyPetts convierte las tareas dispersas en una rutina que puedes entender de un vistazo. Sin estrés, sin olvidos.</p>

                <div class="mt-8 space-y-5">
                    <div class="flex items-start gap-4">
                        <span class="flex-shrink-0 inline-flex w-10 h-10 rounded-xl items-center justify-center" style="background:var(--soft)">
                            <i data-lucide="check-circle" class="w-5 h-5" style="color:var(--brand)"></i>
                        </span>
                        <div>
                            <p class="font-semibold" style="color:var(--navy)">Citas con contexto</p>
                            <p class="text-sm mt-1" style="color:#5C7690">Consulta antecedentes y próximos pasos sin cambiar de pantalla.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="flex-shrink-0 inline-flex w-10 h-10 rounded-xl items-center justify-center" style="background:#fff0e9">
                            <i data-lucide="check-circle" class="w-5 h-5" style="color:var(--accent)"></i>
                        </span>
                        <div>
                            <p class="font-semibold" style="color:var(--navy)">Historial que acompaña</p>
                            <p class="text-sm mt-1" style="color:#5C7690">Cada diagnóstico y tratamiento queda disponible cuando lo necesitas.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="flex-shrink-0 inline-flex w-10 h-10 rounded-xl items-center justify-center" style="background:var(--soft)">
                            <i data-lucide="check-circle" class="w-5 h-5" style="color:var(--brand)"></i>
                        </span>
                        <div>
                            <p class="font-semibold" style="color:var(--navy)">Alertas y reportes listos</p>
                            <p class="text-sm mt-1" style="color:#5C7690">Vacunas visibles y datos claros para compartir con tu equipo veterinario.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== TESTIMONIALS ==================== --}}
        <section id="testimonials" class="max-w-7xl mx-auto px-6 pb-24">
            <div class="text-center mb-14 reveal">
                <p class="text-xs font-semibold uppercase tracking-[.18em] mb-4" style="color:var(--brand-dark)">Lo que dicen nuestros usuarios</p>
                <h2 class="font-display text-3xl sm:text-4xl font-bold" style="color:var(--navy)">Historias de familias que confían en MyPetts</h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 reveal-stagger">
                <div class="testimonial-card">
                    <div class="testimonial-stars text-sm mb-3">★★★★★</div>
                    <p class="text-sm leading-6 mb-5" style="color:#52718b">"Antes llevaba todo en notas del teléfono. Ahora con MyPetts tengo las citas de mis 3 perros organizadas y nunca me pierdo una vacuna."</p>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex w-10 h-10 rounded-full items-center justify-center text-sm font-bold" style="background:var(--soft); color:var(--brand)">MC</span>
                        <div>
                            <p class="text-sm font-semibold" style="color:var(--navy)">María Campos</p>
                            <p class="text-xs" style="color:#5C7690">Dueña de Max, Rex y Luna</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-stars text-sm mb-3">★★★★★</div>
                    <p class="text-sm leading-6 mb-5" style="color:#52718b">"Como veterinario, recomiendo MyPetts a mis clientes. Los reportes que generan facilitan mucho las consultas de seguimiento."</p>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex w-10 h-10 rounded-full items-center justify-center text-sm font-bold" style="background:#fff0e9; color:var(--accent)">DR</span>
                        <div>
                            <p class="text-sm font-semibold" style="color:var(--navy)">Dr. Roberto Vega</p>
                            <p class="text-xs" style="color:#5C7690">Veterinario · Clínica Animal</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-stars text-sm mb-3">★★★★★</div>
                    <p class="text-sm leading-6 mb-5" style="color:#52718b">"Mi gata Misha necesita medicación crónica. Los recordatorios de MyPetts me salvaron de olvidar dosis más de una vez. ¡Increíble herramienta!"</p>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex w-10 h-10 rounded-full items-center justify-center text-sm font-bold" style="background:var(--soft); color:var(--brand)">AP</span>
                        <div>
                            <p class="text-sm font-semibold" style="color:var(--navy)">Ana Pérez</p>
                            <p class="text-xs" style="color:#5C7690">Dueña de Misha</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== FAQ SECTION ==================== --}}
        <section id="faq" class="max-w-3xl mx-auto px-6 pb-24">
            <div class="text-center mb-12 reveal">
                <p class="text-xs font-semibold uppercase tracking-[.18em] mb-4" style="color:var(--accent)">Preguntas frecuentes</p>
                <h2 class="font-display text-3xl sm:text-4xl font-bold" style="color:var(--navy)">¿Tienes dudas? Te las resolvemos</h2>
            </div>

            <div class="space-y-3 reveal" style="animation-delay:.1s">
                <div class="faq-item active">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        ¿MyPetts es gratis?
                        <i data-lucide="chevron-down" class="w-5 h-5 faq-chevron"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-sm leading-6" style="color:#52718b">Sí, MyPetts es completamente gratuito. Puedes crear tu cuenta, agregar todas tus mascotas y usar todas las funciones sin costo alguno.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        ¿Cuántas mascotas puedo registrar?
                        <i data-lucide="chevron-down" class="w-5 h-5 faq-chevron"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-sm leading-6" style="color:#52718b">¡Las que quieras! No hay límite en la cantidad de mascotas que puedes agregar a tu cuenta. Cada una tiene su propio perfil completo.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        ¿Puedo compartir información con mi veterinario?
                        <i data-lucide="chevron-down" class="w-5 h-5 faq-chevron"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-sm leading-6" style="color:#52718b">Sí, puedes generar reportes completos del historial clínico, vacunas y citas de tu mascota para compartirlos fácilmente con tu equipo veterinario.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        ¿Mis datos están seguros?
                        <i data-lucide="chevron-down" class="w-5 h-5 faq-chevron"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-sm leading-6" style="color:#52718b">Absolutamente. Utilizamos encriptación de nivel bancario y seguimos las mejores prácticas de seguridad para proteger toda la información de tus mascotas.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        ¿Funciona para todo tipo de mascotas?
                        <i data-lucide="chevron-down" class="w-5 h-5 faq-chevron"></i>
                    </button>
                    <div class="faq-answer">
                        <p class="text-sm leading-6" style="color:#52718b">MyPetts está diseñado para perros y gatos principalmente, pero puedes registrar cualquier tipo de mascota y llevar el control de su salud.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== CTA FINAL ==================== --}}
        <section class="max-w-7xl mx-auto px-6 pb-24 reveal">
            <div class="cta-section px-8 py-16 sm:px-16 sm:py-20 text-center relative z-10">
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                    Empieza a organizar el cuidado<br class="hidden sm:block"> de tu mascota hoy
                </h2>
                <p class="mt-5 text-base sm:text-lg max-w-lg mx-auto leading-7" style="color:rgba(255,255,255,.75)">
                    Únete a miles de familias que ya confían en MyPetts para cuidar lo que más importa.
                </p>
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="/registro" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl text-base font-semibold transition-all" style="background:white; color:var(--brand-dark); box-shadow:0 12px 28px rgba(0,0,0,.15)" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        Crear cuenta gratis
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="/login" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl text-base font-semibold transition-all" style="background:rgba(255,255,255,.12); color:white; border:1px solid rgba(255,255,255,.2)" onmouseover="this.style.background='rgba(255,255,255,.2)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,.12)'; this.style.transform='translateY(0)'">
                        Ya tengo cuenta
                    </a>
                </div>
            </div>
        </section>

    </main>

    {{-- ==================== FOOTER ==================== --}}
    <footer style="background: #0f2a3e; color: #8aacbf">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2.5 mb-5">
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-2xl text-sm font-bold font-display" style="background:var(--brand); color:white">M</span>
                        <span class="font-display font-bold text-lg text-white">MyPetts</span>
                    </div>
                    <p class="text-sm leading-6" style="color:#6b8fa8">El cuidado de tu mascota, organizado de verdad. Centraliza toda la información veterinaria en un solo lugar.</p>
                </div>

                {{-- Links 1 --}}
                <div>
                    <h4 class="font-display font-semibold text-white text-sm mb-4">Producto</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#features" class="footer-link">Funciones</a></li>
                        <li><a href="#gallery" class="footer-link">Galería</a></li>
                        <li><a href="#testimonials" class="footer-link">Testimonios</a></li>
                        <li><a href="#faq" class="footer-link">Preguntas frecuentes</a></li>
                    </ul>
                </div>

                {{-- Links 2 --}}
                <div>
                    <h4 class="font-display font-semibold text-white text-sm mb-4">Cuenta</h4>
                    <ul class="space-y-2.5">
                        <li><a href="/registro" class="footer-link">Crear cuenta</a></li>
                        <li><a href="/login" class="footer-link">Iniciar sesión</a></li>
                    </ul>
                </div>

                {{-- Social / contact --}}
                <div>
                    <h4 class="font-display font-semibold text-white text-sm mb-4">Conecta</h4>
                    <p class="text-sm leading-6 mb-4" style="color:#6b8fa8">¿Preguntas o sugerencias? Nos encantaría escucharte.</p>
                    <a href="mailto:hola@mypetts.com" class="inline-flex items-center gap-2 footer-link font-medium">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        hola@mypetts.com
                    </a>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-top: 1px solid rgba(138,172,191,.15)">
                <p class="text-sm" style="color:#5c7d93">© {{ date('Y') }} MyPetts. Todos los derechos reservados.</p>
                <div class="flex items-center gap-1">
                    <span class="text-sm" style="color:#5c7d93">Hecho con</span>
                    <i data-lucide="heart" class="w-4 h-4" style="color:var(--accent)"></i>
                    <span class="text-sm" style="color:#5c7d93">para tus mascotas</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        /** FAQ accordion toggle */
        function toggleFaq(button) {
            const item = button.closest('.faq-item');
            const wasActive = item.classList.contains('active');

            // Close all
            document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('active'));

            // Toggle clicked
            if (!wasActive) {
                item.classList.add('active');
            }
        }

        /** Intersection Observer for scroll reveal */
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal, .reveal-stagger > *').forEach(el => {
                el.style.animationPlayState = 'paused';
                observer.observe(el);
            });
        });
    </script>

</body>
</html>