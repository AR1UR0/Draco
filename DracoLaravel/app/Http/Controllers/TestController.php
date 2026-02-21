<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Test; 
use App\Models\Respuesta;

/**
 * Clase TestController
 * * Gestiona el núcleo de la experiencia de usuario (Gameplay).
 * Se encarga de validar el acceso a los cuestionarios según el estado de salud (vidas),
 * procesar las respuestas en tiempo real mediante JSON y gestionar el sistema de 
 * recompensas (Experiencia y Puntos) tanto para usuarios registrados como invitados.
 * * @author Marta
 */
class TestController extends Controller
{
    /**
     * Prepara y muestra la interfaz de resolución de tests.
     * * Verifica la disponibilidad de vidas antes de permitir el acceso. 
     * Implementa una lógica híbrida: consulta el modelo User si hay sesión activa
     * o recurre a la Fachada Session para gestionar invitados.
     * * @author Marta
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function mostrarTest(Request $request)
    {
        if (Auth::check()) {
            $vidas = Auth::user()->current_lives;
        } else {
            $vidas = Session::get('vidas_invitado', 5);
        }

        if ($vidas <= 0) {
            return redirect()->route('pagPrincipal')->with('error', 'No tienes vidas suficientes.');
        }

        return view('preguntaTexto', compact('vidas'));
    }

    /**
     * Evalúa la respuesta seleccionada por el usuario de forma asíncrona.
     * * Este método es el motor lógico del test:
     * 1. Gestiona fallos por tiempo agotado (id_respuesta == -1).
     * 2. Valida la corrección de la respuesta mediante el modelo Respuesta.
     * 3. Calcula y asigna XP y Puntos (Monedas).
     * 4. Sincroniza con el frontend enviando respuestas en formato JSON.
     * * @author Marta
     * @param \Illuminate\Http\Request $request Petición enviada vía AJAX/Fetch.
     * @return \Illuminate\Http\JsonResponse Estado del resultado y progreso actualizado.
     */
    public function comprobarRespuesta(Request $request)
    {
        // Fallo detectado por el JS
        if ($request->id_respuesta == -1) {
            $this->restarVida();
            return response()->json(['status' => 'vida_restada']);
        }

        $respuesta = Respuesta::find($request->id_respuesta);

        if (!$respuesta) {
            return response()->json(['error' => 'Respuesta no encontrada'], 404);
        }

        // Respuesta INCORRECTA
        if (!$respuesta->is_correct) {
            $this->restarVida();
            return response()->json(['status' => 'incorrecto']); 
        }

        // Respuesta CORRECTA
        $pregunta = \App\Models\Pregunta::find($respuesta->pregunta_id);
        $puntosXP = $pregunta->reward_points ?? 10;

        if (Auth::check()) {
            $user = Auth::user();
            $user->experience += $puntosXP; 
            $user->save(); // Dispara el canje de monedas en User.php
            $user->refresh();

            return response()->json([
                'status' => 'success', 
                'xp' => $user->experience,
                'puntos' => $user->points
            ]);
        } else {
            // INVITADO
            $xpActual = Session::get('xp_invitado', 0);
            $puntosActuales = Session::get('puntos_invitado', 0);
            $xpNueva = $xpActual + $puntosXP;

            $bloquesAntiguos = floor($xpActual / 10);
            $bloquesNuevos = floor($xpNueva / 10);

            if ($bloquesNuevos > $bloquesAntiguos) {
                $monedasGanadas = ($bloquesNuevos - $bloquesAntiguos) * 5;
                $puntosActuales += $monedasGanadas;
            }

            Session::put('xp_invitado', $xpNueva);
            Session::put('puntos_invitado', $puntosActuales);
            Session::save();

            return response()->json([
                'status' => 'success', 
                'xp' => $xpNueva,
                'puntos' => $puntosActuales
            ]);
        }
    } 
    
    /**
     * Método auxiliar privado para la gestión de penalizaciones.
     * * Aplica la lógica de "muerte" del jugador:
     * - Si es usuario 'Plus', es inmune a la pérdida de vidas.
     * - Si es usuario normal, decrementa vidas en base de datos.
     * - Si es invitado, decrementa el valor almacenado en la sesión.
     * * @author Marta
     * @return void
     */
    private function restarVida()
    {
        $user = Auth::user();
    
        if ($user && $user->is_plus) {
            return; 
        }
        
        if (Auth::check()) {
            if ($user->current_lives > 0) {
                if ($user->current_lives == $user->max_lives) {
                $user->last_life_recovery = now();
                }
                $user->decrement('current_lives');
                $user->save();
            }
        } else {
            $vidas = Session::get('vidas_invitado', 5);
            if ($vidas > 0) {
                $nuevasVidas = $vidas - 1;
                Session::put('vidas_invitado', $nuevasVidas);
                Session::save();
            }
        }
    }
}