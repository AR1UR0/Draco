<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreguntaController extends Controller
{
    /**
     * Obtener todas las preguntas de un test específico.
     */
    public function getByTest($testId)
    {
        $preguntas = Pregunta::where('test_id', $testId)->get();
        return response()->json($preguntas);
    }

    /**
     * Obtener una sola pregunta con sus respuestas para cargar el formulario de edición.
     */
    public function show($id)
    {
        $pregunta = Pregunta::with('respuestas')->findOrFail($id);
        return response()->json($pregunta);
    }

    /**
     * Guardar una nueva pregunta y sus 4 respuestas (CREATE).
     */
    public function store(Request $request)
    {
        $request->validate([
            'enunciado' => 'required|string',
            'test_id' => 'required|exists:tests,id',
            'respuestas' => 'required|array|min:4',
            'respuestas.*.opcion' => 'required|string',
            'respuestas.*.is_correct' => 'required|boolean',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // 1. Crear la pregunta
                $pregunta = Pregunta::create([
                    'enunciado' => $request->enunciado,
                    'test_id' => $request->test_id,
                    'reward_points' => 10, // Puedes hacerlo dinámico si quieres
                ]);

                // 2. Crear las respuestas asociadas
                foreach ($request->respuestas as $resp) {
                    $pregunta->respuestas()->create([
                        'opcion' => $resp['opcion'],
                        'is_correct' => $resp['is_correct'],
                    ]);
                }

                return response()->json(['message' => 'Pregunta creada con éxito'], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Actualizar una pregunta existente y sus respuestas (UPDATE).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'enunciado' => 'required|string',
            'respuestas' => 'required|array|min:4',
            'respuestas.*.opcion' => 'required|string',
            'respuestas.*.is_correct' => 'required|boolean',
        ]);

        try {
            return DB::transaction(function () use ($request, $id) {
                $pregunta = Pregunta::findOrFail($id);
                
                // 1. Actualizar el enunciado de la pregunta
                $pregunta->update([
                    'enunciado' => $request->enunciado
                ]);

                // 2. Actualizar las respuestas
                // Lo más limpio es borrar las anteriores y crear las nuevas 
                // para evitar conflictos de IDs y lógica de "cuál era cuál"
                $pregunta->respuestas()->delete();

                foreach ($request->respuestas as $resp) {
                    $pregunta->respuestas()->create([
                        'opcion' => $resp['opcion'],
                        'is_correct' => $resp['is_correct'],
                    ]);
                }

                return response()->json(['message' => 'Pregunta actualizada correctamente']);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar una pregunta (DELETE).
     */
    public function destroy($id)
{
    try {
        $pregunta = Pregunta::find($id);
        
        if (!$pregunta) {
            return response()->json(['error' => 'La pregunta no existe en la base de datos'], 404);
        }

        $pregunta->delete();
        return response()->json(['message' => 'Eliminada con éxito'], 200);
    } catch (\Exception $e) {
        // Esto nos dirá si hay un error de claves foráneas o de SQL
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}