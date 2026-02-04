<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// --- RUTAS PÚBLICAS ---
Route::view('/', 'index')->name('index');

// Mostramos la página donde están los dos formularios (Login y Register)
Route::get('/login', function() {
    return view('login'); 
})->name('login');

// Procesos de autenticación
Route::post('/login/ingresar', [LoginController::class, 'login'])->name('login.post');
Route::post('/login/registrar', [RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- RUTAS PARA USUARIOS LOGUEADOS (Cualquier rol) ---
Route::middleware(['auth'])->group(function () {
    Route::view('/pagPrincipal', 'pagPrincipal')->name('pagPrincipal');
    Route::view('/perfil', 'perfil')->name('perfil');
    Route::view('/store', 'store')->name('store');
    Route::view('/first-config', 'firstConfig')->name('firstConfig');

    // Rutas del Test
    Route::get('/test/{id}', [TestController::class, 'mostrarTest'])->name('test.show');
    Route::post('/test/validar', [TestController::class, 'comprobarRespuesta'])->name('test.validar');
});

// --- RUTAS SOLO PARA ADMINISTRADORES ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin', 'admin')->name('admin');
    
    // Aquí irás añadiendo rutas como:
    // Route::get('/admin/usuarios', [AdminController::class, 'index']);
});

// --- UTILIDADES / PLANTILLAS (Puedes dejarlas fuera o dentro) ---
Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::view('/pregunta-texto', 'preguntaTexto')->name('preguntaTexto');
Route::view('/plantilla-media', 'plantillaMedia')->name('plantillaMedia');
Route::view('/plantilla-imagenes', 'plantillaimagenes')->name('plantillaimagenes');