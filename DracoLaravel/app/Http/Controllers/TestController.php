<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Test; // No olvides importar tus modelos
use App\Models\Respuesta;

class TestController extends Controller
{
    public function mostrarTest($id)
    {
        // Obtener las vidas
        if (Auth::check()) {
            $vidas = Auth::user()->vidas_actuales;
        } else {
            $vidas = Session::get('vidas_invitado', 5);
        }

        // Comprobar si puede jugar
        if ($vidas <= 0) {
            return redirect()->back()->with('error', 'No te quedan vidas.');
        }

        // Cargar el test con sus preguntas y respuestas
        $test = Test::with('preguntas.respuestas')->findOrFail($id);

        return view('tests.play', compact('vidas', 'test'));
    }

    // funcion para comprobar las respuestas del usuario
    public function comprobarRespuesta(Request $request)
    {
        $respuesta = Respuesta::find($request->id_respuesta);

        if (!$respuesta->es_correcta) {
            // Si falla, llamamos a nuestra función interna para restar vida
            $this->restarVida();
            return back()->with('mal', 'Respuesta incorrecta, pierdes una vida');
        }

        return back()->with('bien', '¡Correcto!');
    }

    // ESTA FUNCIÓN ES UN MÉTODO PRIVADO (Auxiliar)
    // Se pone aquí dentro pero al final, para que las rutas no la vean directamente
    private function restarVida()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->vidas_actuales > 0) {
                $user->decrement('vidas_actuales');
            }
        } else {
            $vidas = Session::get('vidas_invitado', 5);
            if ($vidas > 0) {
                Session::put('vidas_invitado', $vidas - 1);
            }
        }
    }
}