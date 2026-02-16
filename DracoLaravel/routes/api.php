<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Models\Tematica;
use App\Http\Controllers\PreguntaController;
use App\Models\Test;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register-mail', [MailController::class, 'register']);

Route::get('/tematicas', function () {
    // Esto carga las temáticas y todos sus tests en una sola consulta
    return response()->json(Tematica::with('tests')->get());
});

Route::post('/preguntas', [PreguntaController::class, 'store']);

// Obtener todas las preguntas de un test específico
Route::get('/tests/{test}/preguntas', function (Test $test) {
    return response()->json($test->preguntas);
});

// Obtener una pregunta con sus respuestas para editar
Route::get('/preguntas/{pregunta}', function (App\Models\Pregunta $pregunta) {
    return response()->json($pregunta->load('respuestas'));
});

// Ruta para actualizar (Update)
Route::put('/preguntas/{pregunta}', [PreguntaController::class, 'update']);

//Ruta para eliminar (Delete)
Route::delete('/preguntas/{id}', [PreguntaController::class, 'destroy']);