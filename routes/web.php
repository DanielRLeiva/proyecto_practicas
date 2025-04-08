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

// Solo admin puede crear, editar, borrar
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('aulas/create', [AulaController::class, 'create'])->name('aulas.create');
    Route::post('aulas', [AulaController::class, 'store'])->name('aulas.store');
    Route::get('aulas/{aula}/edit', [AulaController::class, 'edit'])->name('aulas.edit');
    Route::put('aulas/{aula}', [AulaController::class, 'update'])->name('aulas.update');
    Route::delete('aulas/{aula}', [AulaController::class, 'destroy'])->name('aulas.destroy');
});
// Rutas púbicas (sólo ver)
Route::resource('aulas', AulaController::class);

// Rutas para Materiales
Route::resource('materiales', MaterialController::class)->except(['create', 'edit']);
Route::get('materiales/create/{aula_id}', [MaterialController::class, 'create'])->name('materiales.create');
Route::get('materiales/{material}/edit/{aula_id}', [MaterialController::class, 'edit'])->name('materiales.edit');
Route::put('materiales/{aula_id}', [MaterialController::class, 'update'])->name('materiales.update');

// Rutas para Equipos
Route::resource('equipos', EquipoController::class)->except(['create', 'edit']);
Route::get('equipos/create/{aula_id}', [EquipoController::class, 'create'])->name('equipos.create');
Route::get('equipos/{equipo}/edit/{aula_id}', [EquipoController::class, 'edit'])->name('equipos.edit');
Route::put('equipos/{aula_id}', [EquipoController::class, 'update'])->name('equipos.update');

// Rutas para profesores
Route::resource('profesores', ProfesorController::class)
    ->parameters(['profesores' => 'profesor',]);

// Rutas para portatiles
Route::resource('portatiles', PortatilController::class)
    ->parameters(['portatiles' => 'portatil']);

// rutas para usufructos
Route::resource('usufructos', ProfesorPortatilController::class);