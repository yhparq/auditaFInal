<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AulaVirtualController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ParticipanteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DniController;
use App\Http\Controllers\PhotoController;
use Inertia\Inertia;

// ========================================
// RUTAS PÚBLICAS
// ========================================

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// ========================================
// RUTAS DE REGISTRO (PÚBLICAS)
// ========================================

Route::get('/galeria', [PhotoController::class, 'publicIndex'])->name('gallery.index');
Route::get('/galeria/{photo}', [PhotoController::class, 'publicShow'])->name('gallery.show');

// ========================================
// RUTAS DEL AULA VIRTUAL (COLOCAR ANTES DE LAS RUTAS AUTENTICADAS)
// ========================================

Route::prefix('aula-virtual')->group(function () {
    // Ruta principal - mostrar login (pública)
    Route::get('/', [AulaVirtualController::class, 'showLogin'])->name('aula-virtual.login');

    // Procesar login (pública)
    Route::post('/login', [AulaVirtualController::class, 'login'])->name('aula-virtual.login.post');

    // Rutas protegidas - requieren autenticación
    Route::middleware('auth:participante')->group(function () {
        Route::get('/dashboard', [AulaVirtualController::class, 'dashboard'])->name('aula-virtual.dashboard');
        Route::get('/cursos-por-fecha', [AulaVirtualController::class, 'cursosPorFecha'])->name('aula-virtual.cursos-por-fecha');
        Route::get('/descargar-material/{curso}', [AulaVirtualController::class, 'descargarMaterial'])->name('aula-virtual.descargar-material');
        Route::post('/acceder-reunion/{curso}', [AulaVirtualController::class, 'accederReunion'])->name('aula-virtual.acceder-reunion');
        Route::get('/debug', [AulaVirtualController::class, 'debug'])->name('aula-virtual.debug');

        // Logout
        Route::post('/logout', [AulaVirtualController::class, 'logout'])->name('aula-virtual.logout');
    });
});

// GET - Páginas de registro
Route::get('/registro', fn() => Inertia::render('Registro/SeleccionTipo'))->name('registro.seleccion');
Route::get('/registro/individual', fn() => Inertia::render('Registro/Individual'))->name('registro.individual');
Route::get('/registro/corporativo', fn() => Inertia::render('Registro/Corporativo'))->name('registro.corporativo');

// POST - Procesamiento de registros
Route::post('/registro', [ParticipanteController::class, 'store'])->name('registro.store');
Route::post('/registro1', [ParticipanteController::class, 'store1'])->name('registro.store1');

// API para búsqueda de DNI
Route::get('/api/dni/{dni}', [DniController::class, 'buscar'])->name('buscar.dni');

// ========================================
// RUTAS AUTENTICADAS PARA ADMINISTRADORES
// ========================================

// Dashboard para administradores/usuarios del sistema (NO participantes)
Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Participantes individuales
    Route::get('/participantes', [ParticipanteController::class, 'index'])->name('participantes.index');
    Route::get('/participantes/create', [ParticipanteController::class, 'create'])->name('participantes.create');
    Route::post('/participantes', [ParticipanteController::class, 'store'])->name('participantes.store');
    Route::get('/participantes/{participante}/edit', [ParticipanteController::class, 'edit'])->name('participantes.edit');
    Route::put('/participantes/{participante}', [ParticipanteController::class, 'update'])->name('participantes.update');
    Route::delete('/participantes/{participante}', [ParticipanteController::class, 'destroy'])->name('participantes.destroy');
    Route::patch('/participantes/{participante}/toggle-estado', [ParticipanteController::class, 'toggleEstado'])->name('participantes.toggle-estado');

    // Participantes corporativos
    Route::get('/participantes/corporativos', [ParticipanteController::class, 'indexCoporativos'])->name('participantes.corporativos');

    Route::get('/participantes/export/excel', [ParticipanteController::class, 'exportExcel'])->name('participantes.export.excel');

    Route::get('/participantes/corporativos/export/excel', [ParticipanteController::class, 'exportCorporativosExcel'])->name('participantes.corporativos.export.excel');

    Route::resource('/photos', PhotoController::class);
    Route::resource('/cursos', CursoController::class);
    // Route::resource('/asistencias', AsistenciaController::class);
    // Route::post('/asistencias/verificar', [AsistenciaController::class, 'verificar']);
    // Route::get('/asistencias/hoy', [AsistenciaController::class, 'hoy']);
    // Route::get('/asistencias/exportar', [AsistenciaController::class, 'exportar'])->name('asistencias.exportar');

    // Rutas individuales
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::post('/asistencias/verificar', [AsistenciaController::class, 'verificar']);
    Route::get('/asistencias/hoy', [AsistenciaController::class, 'hoy']);
    Route::get('/asistencias/exportar', [AsistenciaController::class, 'exportar']);
});

// ========================================
// ARCHIVOS DE CONFIGURACIÓN
// ========================================

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
