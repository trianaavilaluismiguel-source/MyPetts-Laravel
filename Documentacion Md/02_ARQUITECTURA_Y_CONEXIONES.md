# Arquitectura del Sistema y Conexiones

Este documento describe cómo interactúan los diferentes componentes de **MyPetts**: desde el ciclo de vida de una solicitud HTTP, la capa de middlewares, el enrutamiento, la interacción entre Modelos y Base de Datos, hasta el flujo de atención clínica.

---

## 1. Diagrama General de la Arquitectura

```text
       [ Cliente / Navegador Web ]
                   │
                   ▼  (HTTP GET/POST)
            [ public/index.php ]
                   │
                   ▼
         [ bootstrap/app.php ]
         (Carga de Middlewares globales y de sesión)
                   │
                   ▼
          [ routes/web.php ]
                   │
     ┌─────────────┴─────────────┐
     │                           │
  (Rutas Públicas)       (Middleware: 'auth')
  - Login / Registro             │
  - Olvidé contraseña            ▼
                       [ Middleware: 'rol:X,Y' ]
                       (VerificarRol.php valida perfil)
                                 │
                                 ▼
                     [ Http/Controllers ]
                     (Procesa petición, valida datos)
                                 │
               ┌─────────────────┴─────────────────┐
               ▼                                   ▼
        [ App/Models ]                     [ resources/views ]
        (Lógica Eloquent / BD)             (Plantillas Blade / CSS)
               │                                   │
               ▼                                   ▼
      [ Base de Datos MySQL ]              [ Render HTML al Navegador ]
```

---

## 2. Mapa de Conexiones por Módulo

A continuación se muestra el mapeo directo entre URLs, Controladores, Modelos invocados y Vistas devueltas:

| Módulo | Ruta HTTP | Método | Controlador y Método | Modelos Involucrados | Vistas Blade |
| :--- | :--- | :---: | :--- | :--- | :--- |
| **Inicio Público** | `/` | GET | `Route::view` | N/A | `welcome.blade.php` |
| **Autenticación** | `/login`, `/registro`, `/olvide-password` | GET/POST | `AuthController` | `Usuario`, `TokenRecuperacion` | `auth/*`, `layouts/guest` |
| **Dashboard** | `/dashboard` | GET | `DashboardController@index` | `Usuario`, `Mascota`, `Cita`, `Notificacion` | `dashboard/index.blade.php` |
| **Mascotas** | `/mascota`, `/mascota/ver/{id}` | GET | `MascotaController@index`, `@ver` | `Mascota`, `Usuario` | `mascotas/index.blade.php`, `mascotas/ver.blade.php` |
| **Gestión Mascota** | `/mascota/crear`, `/mascota/editar/{id}`, `/mascota/baja/{id}` | GET/POST | `MascotaController` (Rol 3, 4) | `Mascota`, `Usuario` | `mascotas/crear.blade.php`, `mascotas/editar.blade.php` |
| **Citas** | `/cita` | GET | `CitaController@index` | `Cita`, `Mascota`, `Usuario` | `citas/index.blade.php` |
| **Agendar Cita** | `/cita/crear`, `/cita/reagendar/{id}`, `/cita/cancelar/{id}` | GET/POST | `CitaController` (Rol 3, 4) | `Cita`, `Mascota`, `Usuario` | `citas/crear.blade.php`, `citas/reagendar.blade.php` |
| **Atención Médica**| `/cita/atender/{id}` | POST | `CitaController@atender` (Rol 2) | Redirige según tipo a Vacuna o Historial | N/A (Redirección con token de contexto) |
| **Historial Médico**| `/historial/listar`, `/historial/verHistorial/{id}` | GET | `HistorialController@listar`, `@verHistorial` | `HistorialClinico`, `Mascota` | `historial/listar.blade.php`, `historial/index.blade.php` |
| **Registro Historial**| `/historial/mostrarCrear/{id}`, `/historial/editar/{id}` | GET/POST | `HistorialController` (Rol 2) | `HistorialClinico`, `Cita` | `historial/crear.blade.php`, `historial/editar.blade.php` |
| **Vacunación** | `/vacuna/listar`, `/vacuna/verVacunas/{id}` | GET | `VacunaController@listar`, `@verVacunas` | `VacunaDesparasitacion`, `Mascota` | `vacunas/listar.blade.php`, `vacunas/index.blade.php` |
| **Registro Vacuna**| `/vacuna/mostrarCrear/{id}` | GET/POST | `VacunaController` (Rol 2) | `VacunaDesparasitacion`, `Cita` | `vacunas/crear.blade.php` |
| **Reportes** | `/reporte`, `/reporte/pdf`, `/reporte/excel` | GET | `ReporteController` (Rol 1, 2) | `Reporte`, `Mascota`, `Usuario`, DomPDF, Excel | `reportes/index.blade.php`, `reportes/pdf-*.blade.php` |
| **Estadísticas** | `/estadisticas`, `/estadisticas/pdf`, `/excel` | GET | `EstadisticaController` (Rol 1) | `Estadistica`, DomPDF, Excel | `estadisticas/index.blade.php`, `estadisticas/pdf.blade.php` |
| **Usuarios** | `/usuario`, `/usuario/crear`, `/usuario/editar/{id}`, etc. | GET/POST | `UsuarioController` (Rol 1) | `Usuario`, `Rol` | `usuarios/index.blade.php`, `usuarios/crear.blade.php`, etc. |

---

## 3. Flujo Clave: Ciclo de una Cita Médica

Uno de los flujos más importantes y de mayor integración en el sistema es la atención de una consulta:

```text
[Dueño o Recepcionista]
          │
          ▼
Agendan Cita en /cita/crear ───► Valida Horarios disponibles (Cita::horarioDisponible)
                                 Registra Cita con estado: 'agendada'
                                           │
                                           ▼
[Veterinario en su Agenda] ◄───────────────┘
          │
          ▼
Hace clic en "Atender Cita" (/cita/atender/{id})
          │
          ├──► Si Tipo de Consulta = 'Vacunación' o 'Desparasitación'
          │         │
          │         ▼
          │    Redirige a /vacuna/mostrarCrear/{mascotaId}?cita_id={citaId}
          │         │
          │         ▼
          │    Guarda en tabla 'vacunas_desparasitaciones'
          │    Actualiza Cita a estado: 'completada'
          │
          └──► Para Consulta General / Cirugía / Control / Urgencia
                    │
                    ▼
               Redirige a /historial/mostrarCrear/{mascotaId}?cita_id={citaId}
                    │
                    ▼
               Guarda en tabla 'historial_clinico'
               Actualiza Cita a estado: 'completada'
               Habilita edición solo por 24 horas (puedeEditar())
```

---

## 4. Conexión de Datos y Relaciones Relacionales

La base de datos relacional sigue el siguiente grafo de dependencias de claves foráneas:

```text
     ┌───────────┐
     │   roles   │
     └─────┬─────┘
           │ 1:N
           ▼
     ┌───────────┐ 1:N ┌────────────────────────┐
     │ usuarios  ├────►│  tokens_recuperacion   │
     └─────┬─────┘     └────────────────────────┘
           │
           ├────────────────────────┬────────────────────────┐
           │ 1:N (dueno_id)         │ 1:N (veterinario_id)   │ 1:N (usuario_id)
           ▼                        ▼                        ▼
     ┌───────────┐            ┌───────────┐            ┌─────────────────┐
     │ mascotas  │            │   citas   │            │ notificaciones  │
     └─────┬─────┘            └─────┬─────┘            └─────────────────┘
           │                        │
           ├────────────────────────┼────────────────────────┐
           │ 1:N                    │ 1:1                    │ 1:N
           ▼                        ▼                        ▼
     ┌────────────────────────────────────┐            ┌───────────────────────────────┐
     │         historial_clinico          │            │  vacunas_desparasitaciones    │
     └────────────────────────────────────┘            └───────────────────────────────┘
```

### Reglas de Integridad Referencial:
1. **Borrado Seguro**: Las mascotas y usuarios utilizan bajas lógicas (`activa = false`, `activo = false`) para garantizar que el historial médico y los reportes financieros/operativos históricos nunca pierdan integridad.
2. **Alcance Multi-rol (Data Scoping)**:
   * Los dueños solo pueden consultar y operar sobre mascotas donde `dueno_id == Auth::id()`.
   * Los veterinarios tienen su consulta médica restringida a las mascotas que hayan tenido o tengan citas asignadas a su identificador (`veterinario_id`).
   * Los administradores y recepcionistas disponen de visibilidad global clínica y de agenda.
