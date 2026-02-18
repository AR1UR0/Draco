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
    // 1. Si el JS envía -1 (fallo detectado en el frontend), restamos vida
    if ($request->id_respuesta == -1) {
        $this->restarVida();
        return response()->json(['status' => 'vida_restada']);
    }

    // 2. Buscamos la respuesta en la DB
    $respuesta = Respuesta::find($request->id_respuesta);

    if (!$respuesta) {
        return response()->json(['error' => 'Respuesta no encontrada'], 404);
    }

    // 3. Si la respuesta es INCORRECTA
    if (!$respuesta->is_correct) {
        $this->restarVida();
        return back()->with('error', 'Respuesta incorrecta, pierdes una vida');
    }

    // 4. Si la respuesta es CORRECTA y el usuario está logueado
    if (Auth::check()) {
        $user = Auth::user();
        
        // Buscamos la pregunta para obtener sus puntos de recompensa
        // Si por algún motivo reward_points fuera null, ponemos 10 por defecto
        $pregunta = \App\Models\Pregunta::find($respuesta->pregunta_id);
        $puntos = $pregunta->reward_points ?? 10;

        // Sumamos la experiencia al usuario
        // Al usar increment(), Laravel dispara el evento 'updating' de tu modelo User
        // y automáticamente se hará el canje por monedas si llega a 10 XP.
        $user->increment('experience', $puntos);

        return response()->json([
            'status' => 'success', 
            'xp' => $user->experience,
            'puntos' => $user->points
        ]);
    }

    return response()->json(['status' => 'ok']);
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
                $nuevasVidas = $vidas - 1;
                Session::put('vidas_invitado', $nuevasVidas);
                Session::save();
            }
        }
    }
}