<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\TematicaController;
use App\Http\Controllers\StoreController;

/**
 * @fileoverview Definición del Sistema de Rutas (Routing).
 * Organiza los puntos de entrada de la aplicación mediante la asignación de
 * URLs a controladores específicos, aplicando capas de seguridad por roles.
 * @author Marta Thais
 */
// --- 1. RUTAS PÚBLICAS (Accesibles para invitados y usuarios) ---
/**
 * Incluye la página de aterrizaje, el asistente de configuración inicial y el Dashboard.
 * También gestiona el flujo de acceso (Login) y creación de cuentas (Register).
 */
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
Route::post('/password/reset', [LoginController::class, 'sendTempPassword'])->name('password.email');


// --- 2. RUTAS PARA USUARIOS LOGUEADOS ---
/**
 * Middleware 'auth': Solo usuarios logueados.
 * Middleware 'streak': Ejecuta la lógica de actualización de racha diaria al navegar.
 * Middleware 'nocache': Evita que el usuario vuelva atrás a páginas protegidas tras el logout.
 */
Route::middleware(['auth', 'nocache', 'streak'])->group(function () {
    Route::view('/perfil', 'perfil')->name('perfil');
    Route::get('/store', [StoreController::class, 'index'])->name('store');
    Route::post('/store/buy-life', [StoreController::class, 'buyLife'])->name('buy.life');
    Route::post('/store/buy-plus', [StoreController::class, 'buyPlus'])->name('buy.plus');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


// --- 3. CAPA DE SEGURIDAD: NIVEL ADMINISTRADOR ---
/**
 * Middleware 'admin': Restringe el acceso exclusivamente a usuarios con role_id de administrador.
 */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin', 'admin')->name('admin');
});


// --- 4. UTILIDADES Y PLANTILLAS ---
Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::get('/pregunta-texto', [TestController::class, 'mostrarTest'])->name('preguntaTexto');
Route::view('/plantilla-media', 'plantillaMedia')->name('plantillaMedia');
Route::view('/plantilla-imagenes', 'plantillaimagenes')->name('plantillaimagenes');




// Se utilizó una ruta de pruebas temporal para validar el servicio SMTP, la cual ha sido comentada tras verificar la correcta recepción de los emails. Se deja comentada por si se requiere realizar pruebas
// Route::get('/test-mail', function () {
//     Mail::to('xyz.arturool@gmail.com')->send(new RegisterMail('Arturo'));

//     return 'Correo enviado';
// });
