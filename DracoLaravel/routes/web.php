<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// --- 1. RUTAS PÚBLICAS (Accesibles para invitados y usuarios) ---
Route::view('/', 'index')->name('index');
Route::view('/first-config', 'firstConfig')->name('firstConfig');
Route::view('/pagPrincipal', 'pagPrincipal')->name('pagPrincipal');

// Rutas del Test (Públicas)
Route::get('/test/{id}', [TestController::class, 'mostrarTest'])->name('test.show');
Route::post('/test/validar', [TestController::class, 'comprobarRespuesta'])->name('test.validar');

// Login y Registro (Vistas y Procesos)
Route::get('/login', function() { return view('login'); })->name('login');
Route::post('/login/ingresar', [LoginController::class, 'login'])->name('login.post');
Route::post('/login/registrar', [RegisterController::class, 'register'])->name('register.post');


// --- 2. RUTAS PARA USUARIOS LOGUEADOS ---
Route::middleware(['auth'])->group(function () {
    Route::view('/perfil', 'perfil')->name('perfil');
    Route::view('/store', 'store')->name('store');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


// --- 3. RUTAS SOLO PARA ADMINISTRADORES ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin', 'admin')->name('admin');
});


// --- 4. UTILIDADES Y PLANTILLAS ---
Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::view('/pregunta-texto', 'preguntaTexto')->name('preguntaTexto');
Route::view('/plantilla-media', 'plantillaMedia')->name('plantillaMedia');
Route::view('/plantilla-imagenes', 'plantillaimagenes')->name('plantillaimagenes');