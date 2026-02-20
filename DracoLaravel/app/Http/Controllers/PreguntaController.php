<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Clase PreguntaController
 * * Gestiona el ciclo de vida completo (CRUD) de las preguntas y sus respuestas asociadas.
 * Este controlador es fundamental para la administración de contenidos del proyecto DRACO,
 * permitiendo la creación, edición, consulta y eliminación de ítems de evaluación.
 * * @author Thais
 */
class PreguntaController extends Controller
{
    /**
     * Obtiene la colección de preguntas pertenecientes a un test.
     * * @author Thais
     * @param int $testId ID del test del cual se quieren recuperar las preguntas.
     * @return \Illuminate\Http\JsonResponse Lista de preguntas en formato JSON.
     */
    public function getByTest($testId)
    {
        $preguntas = Pregunta::where('test_id', $testId)->get();
        return response()->json($preguntas);
    }

    /**
     * Recupera una pregunta específica con su relación de respuestas.
     * * @author Thais
     * @param int $id ID único de la pregunta.
     * @return \Illuminate\Http\JsonResponse Datos de la pregunta y sus opciones de respuesta.
     */
    public function show($id)
    {
        $pregunta = Pregunta::with('respuestas')->findOrFail($id);
        return response()->json($pregunta);
    }

    /**
     * Almacena una nueva pregunta y sus respuestas en la base de datos.
     * * Implementa DB::transaction para garantizar la integridad referencial:
     * si la creación de la pregunta tiene éxito pero las respuestas fallan,
     * se realiza un rollback automático.
     * * @author Thais
     * @param \Illuminate\Http\Request $request Datos validados del formulario.
     * @return \Illuminate\Http\JsonResponse Confirmación de creación o mensaje de error.
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
                    'reward_points' => 10, 
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
     * Actualiza una pregunta y sustituye sus respuestas existentes.
     * * Utiliza una estrategia de "borrado y recreación" de respuestas para simplificar
     * la lógica de actualización y mantener la limpieza de los registros.
     * * @author Thais
     * @param \Illuminate\Http\Request $request Datos actualizados.
     * @param int $id ID de la pregunta a modificar.
     * @return \Illuminate\Http\JsonResponse Estado de la actualización.
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
     * Elimina una pregunta de la base de datos.
     * * @author Thais
     * @param int $id ID de la pregunta a eliminar.
     * @return \Illuminate\Http\JsonResponse Resultado de la eliminación.
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