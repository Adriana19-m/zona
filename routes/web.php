<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EncuentroController;
use App\Http\Controllers\RiesgoController;
use App\Http\Controllers\SegurasController;
use Illuminate\Support\Facades\Route;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Ruta de logout (solo para usuarios autenticados)
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/seguras/enviar-mapa', [SegurasController::class, 'enviarMapa'])->name('seguras.enviarMapa');
Route::get('/seguras/generar-pdf', [SegurasController::class, 'generarPDF'])->name('seguras.pdf');
Route::get('/riesgos/mapa', [RiesgoController::class, 'mapa'])->name('riesgos.mapa');
// Rutas de recursos
Route::resource('riesgos', RiesgoController::class);
Route::resource('seguras', SegurasController::class);
Route::resource('encuentros', EncuentroController::class);

// Rutas adicionales para mapas

Route::get('encuentros-mapa', [EncuentroController::class, 'mapa'])->name('encuentros.mapa');
// Ruta resource que incluye show (si la necesitas)


