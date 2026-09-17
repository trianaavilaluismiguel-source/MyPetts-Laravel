<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VacunaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('inicio');

// Auth
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registro', [AuthController::class, 'mostrarRegistro']);
Route::post('/registro', [AuthController::class, 'registrar']);

Route::get('/olvide-password', [AuthController::class, 'olvidePassword']);
Route::post('/olvide-password', [AuthController::class, 'enviarRecuperacion']);

Route::get('/restablecer/{token}', [AuthController::class, 'restablecer']);
Route::post('/restablecer/{token}', [AuthController::class, 'procesarRestablecer']);

Route::middleware('auth')->group(function () {
    Route::get('/cambiar-password', [AuthController::class, 'mostrarCambioPassword']);
    Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mascotas: ver/consultar → cualquier rol logueado (cada uno ve su alcance)
    Route::get('/mascota', [MascotaController::class, 'index']);
    Route::get('/mascota/ver/{id}', [MascotaController::class, 'ver']);

    // Mascotas: gestionar (crear/editar/baja) → HU-03: solo DueñoMascota(4) y Recepcionista(3)
    Route::middleware('rol:3,4')->group(function () {
        Route::get('/mascota/crear', [MascotaController::class, 'mostrarCrear']);
        Route::post('/mascota/crear', [MascotaController::class, 'crear']);
        Route::get('/mascota/editar/{id}', [MascotaController::class, 'mostrarEditar']);
        Route::post('/mascota/editar/{id}', [MascotaController::class, 'editar']);
        Route::post('/mascota/baja/{id}', [MascotaController::class, 'darDeBaja']);
    });

    // Citas: consultar → cualquier rol logueado
    Route::get('/cita', [CitaController::class, 'index']);

    // Citas: agendar/cancelar/reagendar → HU-04: solo DueñoMascota(4) y Recepcionista(3)
    Route::middleware('rol:3,4')->group(function () {
        Route::get('/cita/crear', [CitaController::class, 'mostrarCrear']);
        Route::post('/cita/crear', [CitaController::class, 'crear']);
        Route::post('/cita/cancelar/{id}', [CitaController::class, 'cancelar']);
        Route::get('/cita/reagendar/{id}', [CitaController::class, 'mostrarReagendar']);
        Route::post('/cita/reagendar/{id}', [CitaController::class, 'reagendar']);
    });

    // Atender cita → solo Veterinario(2)
    Route::middleware('rol:2')->post('/cita/atender/{id}', [CitaController::class, 'atender']);

    // Historial clínico: consultar → cualquier rol logueado
    Route::get('/historial/listar', [HistorialController::class, 'listar']);
    Route::get('/historial/verHistorial/{mascotaId}', [HistorialController::class, 'verHistorial']);

    // Historial clínico: registrar/editar → HU-05: solo Veterinario(2)
    Route::middleware('rol:2')->group(function () {
        Route::get('/historial/mostrarCrear/{mascotaId}', [HistorialController::class, 'mostrarCrear']);
        Route::post('/historial/crear/{mascotaId}', [HistorialController::class, 'crear']);
        Route::get('/historial/editar/{id}', [HistorialController::class, 'mostrarEditar']);
        Route::post('/historial/editar/{id}', [HistorialController::class, 'editar']);
    });

    // Vacunas: consultar → cualquier rol logueado
    Route::get('/vacuna/listar', [VacunaController::class, 'listar']);
    Route::get('/vacuna/verVacunas/{mascotaId}', [VacunaController::class, 'verVacunas']);

    // Vacunas: registrar → HU-05: solo Veterinario(2)
    Route::middleware('rol:2')->group(function () {
        Route::get('/vacuna/mostrarCrear/{mascotaId}', [VacunaController::class, 'mostrarCrear']);
        Route::post('/vacuna/crear/{mascotaId}', [VacunaController::class, 'crear']);
    });

    // Reportes → HU-08: solo Administrador(1) y Veterinario(2)
    Route::middleware('rol:1,2')->group(function () {
        Route::get('/reporte', [ReporteController::class, 'index']);
        Route::get('/reporte/pdf', [ReporteController::class, 'exportarPdf']);
        Route::get('/reporte/excel', [ReporteController::class, 'exportarExcel']);
    });

    // Usuarios y Estadísticas → HU-07/HU-09: solo Administrador(1)
    Route::middleware('rol:1')->group(function () {
        Route::get('/usuario', [UsuarioController::class, 'index']);
        Route::get('/usuario/crear', [UsuarioController::class, 'mostrarCrear']);
        Route::post('/usuario/crear', [UsuarioController::class, 'crear']);
        Route::get('/usuario/editar/{id}', [UsuarioController::class, 'mostrarEditar']);
        Route::post('/usuario/editar/{id}', [UsuarioController::class, 'editar']);
        Route::post('/usuario/estado/{id}', [UsuarioController::class, 'cambiarEstado']);
        Route::post('/usuario/resetear/{id}', [UsuarioController::class, 'resetearContrasena']);

        Route::get('/estadisticas', [EstadisticaController::class, 'index']);
        Route::get('/estadisticas/pdf', [EstadisticaController::class, 'exportarPdf']);
        Route::get('/estadisticas/excel', [EstadisticaController::class, 'exportarExcel']);
    });
});
