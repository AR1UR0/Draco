<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Models\Tematica;
use App\Http\Controllers\PreguntaController;
use App\Models\Test;
use App\Models\Pregunta;
use App\Models\Respuesta;

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

// Ruta para obtener las preguntas de un Test específico
Route::get('/preguntas', function (Request $request) {
    return Pregunta::where('test_id', $request->test_id)->get();
});

// Ruta para obtener las respuestas de una pregunta específica
Route::get('/respuestas', function (Request $request) {
    return Respuesta::where('pregunta_id', $request->pregunta_id)->get();
});

// Ruta para obtener el Test según temática y orden
Route::get('/tests', function (Request $request) {
    return Test::where('tematica_id', $request->tematica_id)
               ->where('order', $request->order)
               ->get();
});