<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'index')->name('index');

Route::view('/admin', 'admin')->name('admin');

Route::view('/login', 'login')->name('login');

Route::view('/pagPrincipal', 'pagPrincipal')->name('pagPrincipal');

Route::view('/store', 'store')->name('store');

Route::view('/perfil', 'perfil')->name('perfil');

Route::view('/first-config', 'firstConfig')->name('firstConfig');

// Plantillas de preguntas y utilidades
Route::view('/plantilla', 'plantilla')->name('plantilla');
Route::view('/pregunta-texto', 'preguntaTexto')->name('preguntaTexto');
Route::view('/plantilla-media', 'plantillaMedia')->name('plantillaMedia');
Route::view('/plantilla-imagenes', 'plantillaimagenes')->name('plantillaimagenes');

// Ruta para CARGAR el test (GET)
Route::get('/test/{id}', [TestController::class, 'mostrarTest'])->name('test.show');

// Ruta para PROCESAR la respuesta y restar vidas (POST)
Route::post('/test/validar', [TestController::class, 'comprobarRespuesta'])->name('test.validar');


