<?php

use App\Http\Controllers\EncuentroController;
use App\Http\Controllers\RiesgoController;
use App\Http\Controllers\SegurasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Ruta extra para el mapa (no incluida en Route::resource)
Route::get('/riesgos/mapa', [RiesgoController::class, 'mapa'])->name('riesgos.mapa');
Route::get('encuentros-mapa', [EncuentroController::class, 'mapa'])->name('encuentros.mapa');

// Rutas RESTful: index, create, store, edit, update, destroy, show
Route::resource('riesgos', RiesgoController::class);

Route::resource('seguras', SegurasController::class);


Route::resource('encuentros', EncuentroController::class);
