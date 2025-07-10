<?php

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

Route::get('/aula-virtual', [CursoController::class, 'aulaVirtual'])->name('aula-virtual');
Route::get('/aula-virtual/{curso}', [CursoController::class, 'mostrarCurso'])->name('aula-virtual.curso');


// GET - Páginas de registro
Route::get('/registro', fn () => Inertia::render('Registro/SeleccionTipo'))->name('registro.seleccion');
Route::get('/registro/individual', fn () => Inertia::render('Registro/Individual'))->name('registro.individual');
Route::get('/registro/corporativo', fn () => Inertia::render('Registro/Corporativo'))->name('registro.corporativo');

// POST - Procesamiento de registros
Route::post('/registro', [ParticipanteController::class, 'store'])->name('registro.store');
Route::post('/registro1', [ParticipanteController::class, 'store1'])->name('registro.store1');

// API para búsqueda de DNI
Route::get('/api/dni/{dni}', [DniController::class, 'buscar'])->name('buscar.dni');

// ========================================
// RUTAS AUTENTICADAS
// ========================================

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Participantes individuales
    Route::get('/participantes', [ParticipanteController::class, 'index'])->name('participantes.index');
    Route::get('/participantes/create', [ParticipanteController::class, 'create'])->name('participantes.create');
    Route::post('/participantes', [ParticipanteController::class, 'store'])->name('participantes.store');
    Route::get('/participantes/{participante}/edit', [ParticipanteController::class, 'edit'])->name('participantes.edit');
    Route::put('/participantes/{participante}', [ParticipanteController::class, 'update'])->name('participantes.update');
    Route::delete('/participantes/{participante}', [ParticipanteController::class, 'destroy'])->name('participantes.destroy');
    
    // Participantes corporativos
    Route::get('/participantes/corporativos', [ParticipanteController::class, 'indexCoporativos'])->name('participantes.corporativos');

    Route::resource('/photos', PhotoController::class);
    Route::resource('cursos', CursoController::class);

});

// ========================================
// ARCHIVOS DE CONFIGURACIÓN
// ========================================

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';