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
        // Obtener las vidas
        if (Auth::check()) {
            $vidas = Auth::user()->current_lives;
        } else {
            $vidas = Session::get('vidas_invitado', 5);
        }

        // Si intenta entrar con 0 vidas, lo mandamos a la principal con error
        if ($vidas <= 0) {
            return redirect()->route('pagPrincipal')->with('error', 'No tienes vidas suficientes. ¡Pásate por la tienda!');
        }

        return view('preguntaTexto', compact('vidas'));
    }

    // funcion para comprobar las respuestas del usuario
    public function comprobarRespuesta(Request $request)
    {
        if ($request->id_respuesta == -1) {
        $this->restarVida();
        return response()->json(['status' => 'vida_restada']);
        }

        $respuesta = Respuesta::find($request->id_respuesta);

        if (!$respuesta->is_correct) {
            $this->restarVida();
            // Usamos 'error' para que tu Toast rojo lo detecte
            return back()->with('error', 'Respuesta incorrecta, pierdes una vida');
        }

        // --- AQUÍ AÑADIMOS LA LÓGICA DE EXPERIENCIA ---
        if (Auth::check()) {
            $user = Auth::user();
            
            // Accedemos a la pregunta para saber cuánto vale (reward_points)
            $pregunta = \App\Models\Pregunta::find($respuesta->pregunta_id);
            $puntos = $pregunta->reward_points ?? 10;

            // Sumamos la experiencia
            $user->increment('experience', $puntos);

            // Como pusimos el evento 'updating' en el modelo User, 
            // la base de datos convertirá los 10 XP en 5 monedas automáticamente.
            
            return back()->with('success', "¡Correcto! Has ganado $puntos de XP.");
        }

        return back()->with('success', '¡Correcto!');
    }

    // ESTA FUNCIÓN ES UN MÉTODO PRIVADO (Auxiliar)
    // Se pone aquí dentro pero al final, para que las rutas no la vean directamente
    private function restarVida()
    {
        $user = Auth::user();
    
        // Si es Plus, NO restamos nada, salimos de la función
        if ($user && $user->is_plus) {
            return; 
        }
        
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->current_lives > 0) {
                $user->decrement('current_lives');
            }
        } else {
            $vidas = Session::get('vidas_invitado', 5);
            if ($vidas > 0) {
                Session::put('vidas_invitado', $vidas - 1);
            }
        }
    }
}