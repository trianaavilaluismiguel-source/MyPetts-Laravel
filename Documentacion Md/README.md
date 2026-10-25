# Documentación Oficial del Proyecto MyPetts

Bienvenido al índice de documentación del sistema de gestión veterinaria **MyPetts**. La documentación ha sido dividida en guías técnicas modulares para facilitar su lectura y mantenimiento:

---

## Índice de Documentos

1. ### [01. Estructura de Carpetas y Archivos](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/Documentacion%20Md/01_ESTRUCTURA_CARPETAS.md)
   * Árbol completo del proyecto.
   * Descripción de cada carpeta (`app/`, `resources/views/`, `database/`, etc.).
   * Desglose de controladores y modelos principales.

2. ### [02. Arquitectura del Sistema y Conexiones](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/Documentacion%20Md/02_ARQUITECTURA_Y_CONEXIONES.md)
   * Diagrama del ciclo de vida de peticiones HTTP.
   * Tabla de conexiones: Rutas ➔ Middlewares ➔ Controladores ➔ Modelos ➔ Vistas Blade.
   * Diagrama de flujo de atención de citas médicas.
   * Modelo entidad-relación y reglas de visibilidad por alcance (*data scoping*).

3. ### [03. Funcionalidades del Sistema y Reglas de Negocio](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/Documentacion%20Md/03_FUNCIONALIDADES_Y_MODULOS.md)
   * Matriz de roles y permisos (Administrador, Veterinario, Recepcionista, Dueño).
   * Detalle funcional de historias de usuario (HU-01 a HU-09).
   * Reglas de negocio críticas (bloqueo por intentos fallidos, regla de cancelación de 24h, inmutabilidad del historial clínico a las 24h, bajas lógicas).

4. ### [04. Guía de Base de Datos, Despliegue y Pruebas](file:///home/luis_avila/Escritorio/proyecto-personal/mypetts-laravel/Documentacion%20Md/04_GUIA_DESPLIEGUE_Y_BASE_DATOS.md)
   * Catálogo de las 12 migraciones de base de datos.
   * Pasos de instalación y configuración de variables de entorno.
   * Credenciales de acceso de usuarios Demo precargados (`DemoDataSeeder`).
   * Guía de ejecución de pruebas unitarias y de integración (`phpunit`).
