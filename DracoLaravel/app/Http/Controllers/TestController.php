<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Test; 
use App\Models\Respuesta;

class TestController extends Controller
{
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

    public function comprobarRespuesta(Request $request)
    {
        // 1. Fallo detectado por el JS
        if ($request->id_respuesta == -1) {
            $this->restarVida();
            return response()->json(['status' => 'vida_restada']);
        }

        $respuesta = Respuesta::find($request->id_respuesta);

        if (!$respuesta) {
            return response()->json(['error' => 'Respuesta no encontrada'], 404);
        }

        // 2. Respuesta INCORRECTA
        // CAMBIO IMPORTANTE: Enviamos JSON para no romper el JS de Thais
        if (!$respuesta->is_correct) {
            $this->restarVida();
            return response()->json(['status' => 'incorrecto']); 
        }

        // 3. Respuesta CORRECTA
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
    } // <-- Esta es la llave que faltaba y daba error de compilación

    private function restarVida()
    {
        $user = Auth::user();
    
        if ($user && $user->is_plus) {
            return; 
        }
        
        if (Auth::check()) {
            if ($user->current_lives > 0) {
                $user->decrement('current_lives');
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