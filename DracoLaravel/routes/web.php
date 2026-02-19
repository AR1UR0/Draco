<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\TematicaController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// --- 1. RUTAS PÚBLICAS (Accesibles para invitados y usuarios) ---
Route::view('/', 'index')->name('index');
Route::view('/first-config', 'firstConfig')->name('firstConfig');
Route::get('/pagPrincipal', [TematicaController::class, 'index'])->name('pagPrincipal');

// Rutas del Test (Públicas)
Route::get('/test/{id}', [TestController::class, 'mostrarTest'])->name('test.show');
Route::post('/test/validar', [TestController::class, 'comprobarRespuesta'])->name('test.validar');

// Login y Registro (Vistas y Procesos)
Route::get('/login', function() { return view('login'); })->name('login');
Route::post('/login/ingresar', [LoginController::class, 'login'])->name('login.post');
Route::post('/login/registrar', [RegisterController::class, 'register'])->name('register.post');


// --- 2. RUTAS PARA USUARIOS LOGUEADOS ---
Route::middleware(['auth', 'nocache', 'streak'])->group(function () {
    Route::view('/perfil', 'perfil')->name('perfil');
    Route::get('/store', [StoreController::class, 'index'])->name('store');
    Route::post('/store/buy-life', [StoreController::class, 'buyLife'])->name('buy.life');
    Route::post('/store/buy-plus', [StoreController::class, 'buyPlus'])->name('buy.plus');
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




Route::get('/test-mail', function () {
    Mail::to('xyz.arturool@gmail.com')->send(new RegisterMail('Arturo'));

    return 'Correo enviado';
});


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetEmail'])->name('password.email');


Route::get('/test-reset-mail', function () {
    $url = url('/reset-password?token=123456');

    Mail::to('xyz.arturool@gmail.com')->send(
        new ResetPasswordMail('Arturo', $url)
    );

    return 'Correo de recuperación enviado';
});