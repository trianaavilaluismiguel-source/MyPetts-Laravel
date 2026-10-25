# Funcionalidades del Sistema y Módulos

Este documento detalla todas las funcionalidades, reglas de negocio e historias de usuario (HU) implementadas en el sistema **MyPetts**.

---

## 1. Matriz de Roles y Permisos

El sistema cuenta con 4 roles principales controlados mediante el middleware `rol:X,Y`:

| Funcionalidad / Módulo | DueñoMascota (4) | Recepcionista (3) | Veterinario (2) | Administrador (1) |
| :--- | :---: | :---: | :---: | :---: |
| Registro e Inicio de Sesión | Sí (Público) | Solo Login | Solo Login | Solo Login |
| Ver Dashboard personalizado | Sí (Propias) | Sí (Clínica) | Sí (Consultas) | Sí (Global) |
| Consultar Mascotas | Propias | Todas | Pacientes propios | Todas |
| Registrar / Editar Mascotas | Sí (Propias) | Sí (Cualquiera) | No | No (Directo) |
| Agendar / Reagendar Citas | Sí (Propias) | Sí (Cualquiera) | No | No |
| Cancelar Cita (Regla > 24h) | Sí (Propias) | Sí | No | No |
| Atender Citas Médicas | No | No | Sí | No |
| Consultar Historial y Vacunas | Propias | Todas | Pacientes propios | Todas |
| Registrar Entrada Clínica / Vacuna | No | No | Sí | No |
| Editar Historial (< 24h) | No | No | Sí (Propias) | No |
| Generar y Exportar Reportes (PDF/Excel)| No | No | Sí | Sí |
| Panel de Estadísticas y Comparativas | No | No | No | Sí |
| Gestión de Usuarios y Roles | No | No | No | Sí |
| Resetear Contraseñas a Terceros | No | No | No | Sí |

---

## 2. Descripción Detallada de Módulos

### 2.1 Autenticación y Seguridad de Cuentas (HU-01 & HU-02)
* **Registro de Clientes**: Formulario público donde cualquier usuario puede registrarse con validación de contraseña segura (mínimo 8 caracteres, alfanumérica). Se asigna por defecto el rol **DueñoMascota (4)**.
* **Control de Intentos Fallidos**: Tras 3 intentos incorrectos de contraseña, el sistema bloquea automáticamente la cuenta por 5 minutos mediante la columna `bloqueado_hasta`.
* **Recuperación de Contraseña**: Generación de tokens seguros aleatorios (`TokenRecuperacion`) con vigencia estricta de 30 minutos.
* **Cambio Forzoso de Clave**: Si un usuario fue creado o reseteado por un administrador, se marca `requiere_cambio_pwd = true` obligándolo a cambiar su contraseña temporal antes de navegar en el sistema.

### 2.2 Gestión de Pacientes / Mascotas (HU-03)
* **Registro de Mascotas**: Se capturan datos esenciales: nombre, especie (perro, gato, ave, etc.), raza, sexo, fecha de nacimiento y peso en kg.
* **Asignación de Dueño**:
  * Un dueño registra sus propias mascotas automáticamente asociadas a su `dueno_id`.
  * La recepcionista puede asociar la mascota a cualquier dueño registrado en la base de datos.
* **Baja Lógica**: Para preservar la historia médica y estadísticas, las mascotas no se eliminan físicamente de la base de datos, sino que se marcan con `activa = false`.
* **Búsqueda Dinámica**: Filtro en tiempo real por nombre de mascota o especie.

### 2.3 Agenda y Gestión de Citas (HU-04)
* **Agendamiento Inteligente**:
  * Horarios predefinidos de atención clínica (`Cita::HORAS_DISPONIBLES`).
  * Validación que impide solapamiento de horarios para un mismo veterinario.
  * **Sugerencia de horarios**: Si un horario está ocupado, el sistema calcula y sugiere automáticamente las franjas horarias libres disponibles para ese veterinario en esa fecha.
* **Regla de Cancelación Restrictiva**:
  * Un cliente o recepcionista solo puede cancelar citas con al menos **24 horas de anticipación**. Si intenta cancelar con menor tiempo, el sistema rechaza la solicitud e indica contactar telefónicamente a la clínica.
* **Reagendamiento**: Permite cambiar la fecha u hora manteniendo la trazabilidad mediante `cita_origen_id` y actualizando el estado anterior a `reagendada`.

### 2.4 Atención Clínica e Historial Médico (HU-05)
* **Flujo Integrado desde la Agenda**: Solo el veterinario asignado puede atender una cita en estado `agendada`.
* **Ruteo Automático**:
  * Si la cita fue clasificada como *Vacunación* o *Desparasitación*, redirige al formulario de vacunas.
  * Si es *Consulta general*, *Cirugía*, *Control* o *Urgencia*, abre el registro de expediente clínico.
* **Ficha Clínica Completa**:
  * Motivo de consulta, diagnóstico, tratamiento prescrito y observaciones adicionales.
  * Al guardar la atención, la cita vinculada pasa automáticamente al estado `completada`.
* **Regla de Inmutabilidad Médica (Ventana de 24 Horas)**:
  * El veterinario que registró una atención médica puede editarla únicamente dentro de las 24 horas posteriores a su creación (`puedeEditar()`). Pasado ese lapso, la ficha queda bloqueada como documento legal veterinario inmutable.

### 2.5 Carnet Preventivo y Vacunas (HU-06)
* **Control de Vacunas y Desparasitaciones**:
  * Registro de producto administrado, número de lote, fecha de aplicación y fecha programada de la próxima dosis.
  * Carnet digital accesible en cualquier momento por el dueño de la mascota o por el cuerpo médico.

### 2.6 Administración de Personal y Usuarios (HU-07)
* **Creación de Cuentas por Administrador**: El Administrador puede dar de alta nuevos usuarios seleccionando su rol (Veterinario, Recepcionista, etc.). El sistema genera una clave temporal aleatoria de 8 caracteres.
* **Activación y Desactivación de Acceso**: Opción para deshabilitar personal sin eliminar registros. Un administrador nunca puede desactivarse a sí mismo para evitar bloqueos del sistema.
* **Reseteo Administrativo de Claves**: Genera una nueva clave temporal forzando el cambio inmediato al iniciar sesión.

### 2.7 Reportes y Exportaciones (HU-08)
* **Tipos de Reporte**:
  1. **Citas por período**: Estados, motivos de consulta, veterinarios y clientes.
  2. **Vacunas aplicadas**: Productos, lotes aplicados, fechas y refuerzos por mascota.
  3. **Mascotas atendidas**: Estadísticas agrupadas por especie y tipo de atención.
* **Formatos de Descarga**:
  * **PDF**: Generado mediante la librería `barryvdh/laravel-dompdf` con encabezados institucionales y formateo limpio.
  * **Excel (.xlsx)**: Generado mediante `maatwebsite/excel` para procesamiento analítico de datos.

### 2.8 Tablero Estadístico Comparativo (HU-09)
* **Métricas Clave (KPIs)**:
  * Total de mascotas activas y usuarios desglosados por rol.
  * Indicadores de efectividad de citas: completadas vs. canceladas vs. agendadas.
  * Total de vacunas aplicadas en el período.
* **Comparador de Períodos**: Permite contrastar los resultados de un rango de fechas contra un período previo (por ejemplo, comparar el mes actual contra el mes anterior) para evaluar el crecimiento de la clínica.
