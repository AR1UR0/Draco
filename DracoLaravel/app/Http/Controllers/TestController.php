<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Test; 
use App\Models\Respuesta;

/**
* TestController Class
* Manages the core of the user experience (Gameplay).
* Validates access to quizzes based on health status (lives),
* processes responses in real time using JSON, and manages the reward system (Experience and Points) for both registered and guest users.
* @author Marta
*/
class TestController extends Controller
{
    /**
    * Prepares and displays the test resolution interface.
    * Checks for available lives before granting access.
    * Implements hybrid logic: queries the User model to see if a session is active
    * or uses the Session Facade to manage guests.
    * @author Marta
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
    * Evaluates the user's selected answer asynchronously.
    * This method is the test's logical engine:
    * 1. Handles timeout failures (response_id == -1).
    * 2. Validates the answer's correctness using the Response model.
    * 3. Calculates and assigns XP and Points (Coins).
    * 4. Synchronizes with the frontend by sending responses in JSON format.
    * @author Marta
    * @param \Illuminate\Http\Request $request Request sent via AJAX/Fetch.
    * @return \Illuminate\Http\JsonResponse Updated result and progress status.
    */
    public function comprobarRespuesta(Request $request)
    {
        
        if ($request->id_respuesta == -1) {
            $this->restarVida();
            return response()->json(['status' => 'vida_restada']);
        }

        $respuesta = Respuesta::find($request->id_respuesta);

        if (!$respuesta) {
            return response()->json(['error' => 'Respuesta no encontrada'], 404);
        }

        
        if (!$respuesta->is_correct) {
            $this->restarVida();
            return response()->json(['status' => 'incorrecto']); 
        }

        
        $pregunta = \App\Models\Pregunta::find($respuesta->pregunta_id);
        $puntosXP = $pregunta->reward_points ?? 10;

        if (Auth::check()) {
            $user = Auth::user();
            $user->experience += $puntosXP; 
            $user->save(); 
            $user->refresh();

            return response()->json([
                'status' => 'success', 
                'xp' => $user->experience,
                'puntos' => $user->points
            ]);
        } else {
            // GUEST
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
    * Private auxiliary method for penalty management.
    * Applies the player's "death" logic:
    * - If a 'Plus' user, they are immune to losing lives.
    * - If a normal user, decrements lives in the database.
    * - If a guest, decrements the value stored in the session.
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