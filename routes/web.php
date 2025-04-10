<?php

use App\Http\Controllers\AulaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PortatilController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ProfesorPortatilController;
use Illuminate\Support\Facades\Route;

// Rutas para login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Rutas para registro
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Ruta para logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para Aulas

// Rutas para admin
Route::middleware(['auth', 'role:admin', 'nocache'])->group(function () {
    Route::resource('aulas', AulaController::class);
});

// Rutas para editors y viewers - solo pueden ver el listado y detalles
Route::middleware(['auth', 'role:admin|editor|viewer', 'nocache'])->group(function () {
    Route::resource('aulas', AulaController::class)->only(['index', 'show']);
});

// =======================
// Rutas para Equipos
// =======================

// Admin - acceso total
Route::middleware(['auth', 'role:admin', 'nocache'])->group(function () {
    Route::resource('equipos', EquipoController::class)
        ->except(['create', 'edit'])
        ->parameters(['equipos' => 'equipo']);

    Route::get('equipos/create/{aula_id}', [EquipoController::class, 'create'])->name('equipos.create');
    Route::get('equipos/{equipo}/edit/{aula_id}', [EquipoController::class, 'edit'])->name('equipos.edit');
    Route::put('equipos/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
});

// Editor - ver, crear y editar
Route::middleware(['auth', 'role:editor|admin', 'nocache'])->group(function () {
    Route::get('equipos/create/{aula_id}', [EquipoController::class, 'create'])->name('equipos.create');
    Route::get('equipos/{equipo}/edit/{aula_id}', [EquipoController::class, 'edit'])->name('equipos.edit');
    Route::post('equipos', [EquipoController::class, 'store'])->name('equipos.store');
    Route::put('equipos/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
});

// Viewer - solo lectura
Route::middleware(['auth', 'role:viewer|editor|admin', 'nocache'])->group(function () {
    Route::get('equipos', [EquipoController::class, 'index'])->name('equipos.index');
    Route::get('equipos/{equipo}', [EquipoController::class, 'show'])->name('equipos.show');
});

// =======================
// Rutas para Materiales
// =======================

// Admin - acceso total
Route::middleware(['auth', 'role:admin', 'nocache'])->group(function () {
    Route::resource('materials', MaterialController::class)
        ->except(['create', 'edit']);
    
    Route::get('materials/create/{aula_id}', [MaterialController::class, 'create'])->name('materials.create');
    Route::get('materials/{material}/edit/{aula_id}', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
});

// Editor - ver, crear y editar
Route::middleware(['auth', 'role:admin|editor', 'nocache'])->group(function () {
    Route::get('materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    
    Route::get('materials/create/{aula_id}', [MaterialController::class, 'create'])->name('materials.create');
    Route::get('materials/{material}/edit/{aula_id}', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::post('materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::put('materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
});

// Viewer - solo lectura
Route::middleware(['auth', 'role:admin|editor|viewer', 'nocache'])->group(function () {
    Route::get('materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
});

// =======================
// Rutas para Profesores
// =======================

// Admin - acceso total
Route::middleware(['auth', 'role:admin', 'nocache'])->group(function () {
    Route::resource('profesors', ProfesorController::class);
});

// Editor - crear y editar
Route::middleware(['auth', 'role:admin|editor', 'nocache'])->group(function () {
    Route::resource('profesors', ProfesorController::class)->only(['create', 'edit', 'store', 'update']);
});

// Viewer - solo ver
Route::middleware(['auth', 'role:admin|editor|viewer', 'nocache'])->group(function () {
    Route::resource('profesors', ProfesorController::class)->only(['index', 'show']);
});

// =======================
// Rutas para Portátiles
// =======================

// Admin - acceso total
Route::middleware(['auth', 'role:admin', 'nocache'])->group(function () {
    Route::resource('portatils', PortatilController::class);
});

// Editor - crear y editar
Route::middleware(['auth', 'role:admin|editor', 'nocache'])->group(function () {
    Route::resource('portatils', PortatilController::class)->only(['create', 'edit', 'store', 'update']);
});

// Viewer - solo ver
Route::middleware(['auth', 'role:admin|editor|viewer', 'nocache'])->group(function () {
    Route::resource('portatils', PortatilController::class)->only(['index', 'show']);
});

// =======================
// Rutas para Usufructos
// =======================

// Admin - acceso total
Route::middleware(['auth', 'role:admin', 'nocache'])->group(function () {
    Route::resource('usufructos', ProfesorPortatilController::class);
});

// Editor - crear y editar
Route::middleware(['auth', 'role:admin|editor', 'nocache'])->group(function () {
    Route::resource('usufructos', ProfesorPortatilController::class)->only(['create', 'edit', 'store', 'update']);
});

// Viewer - solo ver
Route::middleware(['auth', 'role:admin|editor|viewer', 'nocache'])->group(function () {
    Route::resource('usufructos', ProfesorPortatilController::class)->only(['index', 'show']);
});
