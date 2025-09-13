<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\ProyeccionIngresoController;
use App\Http\Controllers\ConceptoIngresoController;

use App\Http\Controllers\EgresosController;
use App\Http\Controllers\ProyeccionEgresoController;
use App\Http\Controllers\ConceptoEgresoController;

use App\Http\Controllers\AhorroMetaController;
use App\Http\Controllers\AhorroProgramadoController;
use App\Http\Controllers\AporteAhorroController;

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/layouts.app', function () {
    return view('layouts.app');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('ahorroMeta', AhorroMetaController::class);
Route::resource('ahorroProgramado', AhorroProgramadoController::class);
Route::resource('aporteAhorro', AporteAhorroController::class);
Route::resource('conceptoEgreso', ConceptoEgresoController::class);
Route::resource('conceptoIngreso', ConceptoIngresoController::class);
Route::resource('egresos', EgresosController::class);
Route::resource('ingreso', IngresoController::class);
Route::resource('proyeccionEgreso', ProyeccionEgresoController::class);
Route::resource('proyeccionIngreso', ProyeccionIngresoController::class);
Route::resource('rol', RolController::class);
Route::resource('usuario', UsuarioController::class);
Route::get('/conceptoegresos/modal', [ConceptoEgresoController::class, 'modal'])
    ->name('conceptoegresos.modal');
    Route::get('/egresos/partials/modal-form', function () {
    return view('egresos.partials.modal-form');
});

Route::get('/egresos/partials/modal-concepto', function () {
    $conceptos = \App\Models\ConceptoEgreso::all();
    return view('egresos.partials.modal-concepto', compact('conceptos'));
});