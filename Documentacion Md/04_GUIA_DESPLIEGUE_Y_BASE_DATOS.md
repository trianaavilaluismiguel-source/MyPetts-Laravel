# Guía de Base de Datos, Despliegue y Pruebas

Esta guía detalla el modelo de datos físico, la instalación local, la ejecución de migraciones, los datos demo precargados y la suite de pruebas automatizadas.

---

## 1. Esquema de Tablas en la Base de Datos

El sistema cuenta con 12 migraciones ejecutadas en el siguiente orden secuencial:

| Archivo de Migración | Tabla Creada | Propósito |
| :--- | :--- | :--- |
| `0001_01_01_000000_create_users_table.php` | `users` | Tabla base Laravel (autenticación por defecto). |
| `0001_01_01_000001_create_cache_table.php` | `cache`, `cache_locks` | Gestión de caché de la aplicación. |
| `0001_01_01_000002_create_jobs_table.php` | `jobs`, `failed_jobs` | Cola de tareas en segundo plano. |
| `2024_01_01_000001_create_roles_table.php` | `roles` | Catálogo de roles (Admin, Veterinario, Recepcionista, Dueño). |
| `2024_01_01_000002_create_usuarios_table.php` | `usuarios` | Cuentas del sistema, contraseña hash, estado y rol. |
| `2024_01_01_000003_create_tokens_recuperacion_table.php` | `tokens_recuperacion` | Tokens temporales para olvido de contraseña. |
| `2024_01_01_000004_create_mascotas_table.php` | `mascotas` | Pacientes caninos/felinos con vínculo a su dueño. |
| `2024_01_01_000005_create_citas_table.php` | `citas` | Agenda médica con fecha, hora, estado y veterinario. |
| `2024_01_01_000006_create_historial_clinico_table.php` | `historial_clinico` | Ficha médica, diagnóstico y tratamiento. |
| `2024_01_01_000007_create_vacunas_desparasitaciones_table.php` | `vacunas_desparasitaciones`| Carnet preventivo y control de refuerzos. |
| `2024_01_01_000008_create_notificaciones_table.php` | `notificaciones` | Registro y fallback de avisos a usuarios. |
| `2024_01_01_000009_create_reportes_generados_table.php` | `reportes_generados` | Historial de auditoría de reportes exportados. |

---

## 2. Instalación y Puesta en Marcha

### Requisitos del Sistema
* **PHP**: 8.3 o superior (con extensiones `pdo_mysql`, `mbstring`, `openssl`, `gd`, `zip`).
* **Composer**: 2.x
* **Node.js**: 20.x o superior con **npm**.
* **Base de datos**: MySQL 8.0+ o MariaDB 10.4+.

### Pasos de Configuración Inicial

1. **Instalar dependencias de PHP**:
   ```bash
   composer install
   ```

2. **Configurar el archivo de entorno**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configurar la base de datos en `.env`**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mypetts
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Ejecutar migraciones y datos de prueba (Seeders)**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Instalar dependencias de frontend y compilar**:
   ```bash
   npm install
   npm run build
   ```

6. **Iniciar el servidor de desarrollo**:
   ```bash
   php artisan serve
   # En otra terminal (opcional para cambios de assets en vivo):
   npm run dev
   ```

---

## 3. Cuentas de Acceso para Pruebas (Demo Data)

El seeder `DemoDataSeeder` genera automáticamente un conjunto de usuarios listos para interactuar con todos los módulos. Todos comparten la misma contraseña:

> **Contraseña universal para usuarios Demo:** `Demo1234!`

| Rol | Correo Electrónico Demo | Acciones Típicas para Probar |
| :--- | :--- | :--- |
| **Administrador** | `demo.admin.1@mypetts.test` | Gestión de usuarios, estadísticas comparativas y reportes globales. |
| **Veterinario** | `demo.veterinario.1@mypetts.test` | Atender citas pendientes, redactar historiales y registrar vacunas. |
| **Recepcionista** | `demo.recepcionista.1@mypetts.test` | Agendar citas para cualquier cliente y registrar nuevas mascotas. |
| **Dueño de Mascota** | `demo.dueno.1@mypetts.test` | Ver sus propias mascotas, agendar consultas y revisar carnet de vacunas. |

*(Nota: Existen 5 usuarios demo creados por cada rol, numerados del 1 al 5).*

---

## 4. Ejecución de Pruebas Automatizadas (Testing)

La suite de pruebas valida la seguridad, reglas de negocio y restricciones de visibilidad por rol:

* **Ejecutar todas las pruebas**:
  ```bash
  php artisan test
  ```

* **Ejecutar pruebas con salida compacta**:
  ```bash
  php artisan test --compact
  ```

* **Ejecutar prueba de control de alcance (ScopeAccessTest)**:
  ```bash
  php artisan test --filter=ScopeAccessTest
  ```

### Qué valida `ScopeAccessTest`:
* Garantiza que un veterinario **solo pueda listar y ver mascotas** sobre las que tenga citas asignadas.
* Comprueba que si un veterinario intenta consultar el historial (`/historial/verHistorial/{id}`) o carnet de vacunas de un paciente ajeno, el sistema responda con un error **HTTP 403 Forbidden**.
