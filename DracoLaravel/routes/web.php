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
* @fileoverview Routing System Definition.
* Organizes application entry points by assigning
* URLs to specific controllers, applying role-based security layers.
* @author Marta Thais
*/
// --- 1. PUBLIC ROUTES (Accessible to guests and users) ---
/**
* Includes the landing page, the initial setup wizard, and the Dashboard.
* Also manages the login and registration flows.
*/
Route::view('/', 'index')->name('index');
Route::view('/first-config', 'firstConfig')->name('firstConfig');
Route::get('/pagPrincipal', [TematicaController::class, 'index'])->name('pagPrincipal');

// Test Routes (Public)
Route::get('/test/{id}', [TestController::class, 'mostrarTest'])->name('test.show');
Route::post('/test/validar', [TestController::class, 'comprobarRespuesta'])->name('test.validar');

// Login and Registration (Views and Processes)
Route::get('/login', function() { return view('login'); })->name('login');
Route::post('/login/ingresar', [LoginController::class, 'login'])->name('login.post');
Route::post('/login/registrar', [RegisterController::class, 'register'])->name('register.post');
Route::post('/password/reset', [LoginController::class, 'sendTempPassword'])->name('password.email');


// --- 2. ROUTES FOR LOGGED-IN USERS ---
/**
* Middleware 'auth': Only logged-in users.
* Middleware 'streak': Executes the daily streak update logic while browsing.
* Middleware 'nocache': Prevents the user from returning to protected pages after logging out.
*/
Route::middleware(['auth', 'nocache', 'streak'])->group(function () {
    Route::view('/perfil', 'perfil')->name('perfil');
    Route::get('/store', [StoreController::class, 'index'])->name('store');
    Route::post('/store/buy-life', [StoreController::class, 'buyLife'])->name('buy.life');
    Route::post('/store/buy-plus', [StoreController::class, 'buyPlus'])->name('buy.plus');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


// --- 3. SECURITY LAYER: ADMINISTRATOR LEVEL ---
/**
* Middleware 'admin': Restricts access exclusively to users with the administrator role_id.
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin', 'admin')->name('admin');
});


// --- 4. UTILITIES AND TEMPLATES ---
Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::get('/pregunta-texto', [TestController::class, 'mostrarTest'])->name('preguntaTexto');
Route::view('/plantilla-media', 'plantillaMedia')->name('plantillaMedia');
Route::view('/plantilla-imagenes', 'plantillaimagenes')->name('plantillaimagenes');




// A temporary test route was used to validate the SMTP service. This route has been commented out after verifying the correct reception of emails. It remains commented out in case further testing is required.
// Route::get('/test-mail', function () {
// Mail::to('xyz.arturool@gmail.com')->send(new RegisterMail('Arturo'));

// return 'Email sent';
// });
