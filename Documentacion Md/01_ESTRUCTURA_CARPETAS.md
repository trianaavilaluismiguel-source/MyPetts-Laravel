# Estructura del Proyecto MyPetts

Este documento detalla la estructura completa de directorios y archivos de la aplicación web veterinaria **MyPetts**, basada en el framework **Laravel 12 / PHP 8.3+**.

---

## Árbol de Directorios Principal

```text
mypetts-laravel/
├── app/                        # Lógica central del backend (Modelos, Controladores, Middlewares, etc.)
│   ├── Exports/                # Clases de exportación para Excel (Maatwebsite/Excel)
│   ├── Http/                   # Capa HTTP (Controladores, Middlewares)
│   │   ├── Controllers/        # Controladores por módulo funcional
│   │   └── Middleware/         # Middlewares de control de acceso e interceptores
│   ├── Models/                 # Modelos Eloquent y lógica de datos
│   └── Providers/              # Proveedores de servicios de la aplicación
├── bootstrap/                  # Archivos de arranque del framework y configuración de middlewares
│   ├── app.php                 # Configuración del pipeline HTTP, routing y excepciones
│   └── providers.php           # Registro de Service Providers
├── config/                     # Archivos de configuración general (app, auth, database, session, etc.)
├── database/                   # Migraciones, factories y seeders
│   ├── factories/              # Generadores de datos de prueba
│   ├── migrations/             # Esquema relacional de la base de datos (tablas)
│   └── seeders/                # Pobladores de base de datos con roles y datos de demo
├── Documentacion Md/           # Documentación modular en Markdown del sistema
│   ├── 01_ESTRUCTURA_CARPETAS.md  # Este archivo
│   ├── 02_ARQUITECTURA_Y_CONEXIONES.md # Flujo de datos y relaciones entre capas
│   ├── 03_FUNCIONALIDADES_Y_MODULOS.md # Módulos, roles y casos de uso
│   └── 04_GUIA_DESPLIEGUE_Y_BASE_DATOS.md # Migraciones, seeders y comandos de ejecución
├── public/                     # Punto de entrada web (index.php, assets compilados)
├── resources/                  # Vistas Blade, hojas de estilo CSS y recursos frontend
│   ├── css/                    # Estilos CSS compilados con Vite / Tailwind CSS
│   ├── js/                     # Scripts frontend (ej. iconos Lucide)
│   └── views/                  # Vistas del sistema organizadas por módulo funcional
├── routes/                     # Definición de rutas del sistema
│   ├── console.php             # Comandos de consola de Artisan
│   ├── index.blade.php         # Recursos auxiliares
│   └── web.php                 # Rutas web, autenticación y middlewares de rol
├── storage/                    # Logs, caché de sesiones, vistas compiladas y descargas
├── tests/                      # Pruebas unitarias y funcionales (PHPUnit)
│   ├── Feature/                # Tests funcionales de integración y control de acceso (ScopeAccessTest)
│   └── Unit/                   # Tests unitarios
├── .env.example                # Variables de entorno de referencia
├── composer.json               # Dependencias de paquetes PHP y scripts de composer
├── package.json                # Dependencias de frontend (Tailwind v4, Vite, Lucide)
├── phpunit.xml                 # Configuración del entorno de pruebas
└── vite.config.js              # Configuración del empaquetador Vite
```

---

## Detalle de Carpetas Clave

### 1. `app/Http/Controllers/`
Contiene la lógica de negocio y mediación entre solicitudes HTTP, modelos y vistas:

* **[AuthController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/AuthController.php)**: Registro de clientes, inicio de sesión, intentos fallidos/bloqueo temporal, reseteo y cambio de contraseñas.
* **[DashboardController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/DashboardController.php)**: Pantalla de inicio personalizada según el rol del usuario (Dueño, Veterinario, Recepcionista, Administrador).
* **[MascotaController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/MascotaController.php)**: CRUD de mascotas, búsqueda, control de visibilidad por alcance y bajas lógicas.
* **[CitaController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/CitaController.php)**: Agendamiento con validación de horarios y disponibilidad, reagendamiento, cancelación (regla de 24h) y pasarela para atención clínica.
* **[HistorialController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/HistorialController.php)**: Ficha médica de mascotas, atención desde citas, listado filtrable y ventana de edición restringida a 24 horas.
* **[VacunaController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/VacunaController.php)**: Registro y carnet digital de vacunación y desparasitación con fechas de aplicación y próxima dosis.
* **[UsuarioController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/UsuarioController.php)**: Gestión de personal y usuarios para Administradores (alta, cambio de rol, desactivación, reseteo de claves).
* **[ReporteController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/ReporteController.php)**: Generación de reportes tabulares y descargas en formatos PDF (DomPDF) y Excel (.xlsx).
* **[EstadisticaController.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Controllers/EstadisticaController.php)**: Métricas globales de la clínica, comparativas de períodos temporales y resúmenes ejecutivos.

### 2. `app/Models/`
Modelos Eloquent que representan las entidades del dominio:

* **[Usuario.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/Usuario.php)**: Entidad autenticable, pertenencia a `Rol`, creador y relaciones con citas y mascotas.
* **[Rol.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/Rol.php)**: Catálogo de perfiles (Administrador = 1, Veterinario = 2, Recepcionista = 3, DueñoMascota = 4).
* **[Mascota.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/Mascota.php)**: Ficha de la mascota, scopes para mascotas activas y relación con su dueño.
* **[Cita.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/Cita.php)**: Agenda médica, validación de cruces de horarios y sugerencia de franjas libres.
* **[HistorialClinico.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/HistorialClinico.php)**: Entradas de diagnósticos, tratamientos y regla de 24 horas para modificaciones.
* **[VacunaDesparasitacion.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/VacunaDesparasitacion.php)**: Esquema preventivo y control de dosis.
* **[Notificacion.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/Notificacion.php)**: Registro de avisos y notificaciones en login si falló el canal externo.
* **[Reporte.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/Reporte.php)** & **[Estadistica.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/Estadistica.php)**: Consultas agregadas y métricas del sistema.
* **[TokenRecuperacion.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Models/TokenRecuperacion.php)**: Manejo de tokens de un solo uso para olvido de clave (vigencia de 30 minutos).

### 3. `app/Http/Middleware/`
* **[VerificarRol.php](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/app/Http/Middleware/VerificarRol.php)**: Interceptor que restringe el acceso a rutas verificando el `rol_id` del usuario autenticado contra los roles autorizados pasados por parámetro (`rol:1,2`, etc.).

### 4. `resources/views/`
Vistas estructuradas con plantillas Blade:
* `layouts/`: 
  * `auth.blade.php`: Panel con navegación lateral, barra superior, tema y control de roles.
  * `guest.blade.php`: Plantilla limpia para login, registro y recuperación de contraseña.
* `auth/`: Vistas de login, registro, cambio y reseteo de clave.
* `dashboard/`: Pantalla inicial contextualizada por perfil.
* `mascotas/`: Listado, consulta individual, creación y edición de mascotas.
* `citas/`: Calendario de citas, agendamiento con franjas horarias y reagendamiento.
* `historial/`: Listado de pacientes, línea de tiempo clínica, registro y edición de diagnóstico.
* `vacunas/`: Listado por mascota y formulario de aplicación de vacunas/desparasitaciones.
* `usuarios/`: Panel de gestión de cuentas y roles para el Administrador.
* `reportes/`: Filtros de períodos, tablas resumen y plantillas de exportación PDF (`pdf-citas`, `pdf-vacunas`, `pdf-mascotas`).
* `estadisticas/`: Gráficos métricos e informes comparativos en pantalla y PDF.

### 5. `database/`
* `migrations/`: Define 12 tablas ordenadas secuencialmente, asegurando claves foráneas consistentes.
* `seeders/`: 
  * `RolSeeder.php`: Crea los roles base del sistema.
  * `DemoDataSeeder.php`: Carga 5 usuarios por cada rol, mascotas asociadas y citas de ejemplo para demostración inmediata.
