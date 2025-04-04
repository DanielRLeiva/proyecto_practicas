<?php

use App\Http\Controllers\AulaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PortatilController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ProfesorPortatilController;
use Illuminate\Support\Facades\Route;

// Rutas para Aulas
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