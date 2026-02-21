<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestoreLives
{
    public function handle(Request $request, Closure $next)
    {
        // Solo actuamos si el usuario está logueado y NO es Plus (el Plus tiene infinito)
        if (Auth::check() && !Auth::user()->is_plus) {
            $user = Auth::user();
            
            // Si tiene menos vidas que el máximo
            if ($user->current_lives < $user->max_lives) {
                $ahora = Carbon::now();
                // Si es la primera vez que pierde vidas, inicializamos el timer
                if (!$user->last_life_recovery) {
                    $user->last_life_recovery = $ahora;
                    $user->save();
                }

                $ultimaRecuperacion = $user->last_life_recovery;
                // Calculamos cuántas horas completas han pasado
                $horasTranscurridas = $ahora->diffInHours($ultimaRecuperacion);

                if ($horasTranscurridas >= 1) {
                    // Calculamos cuántas vidas sumamos (máximo hasta llegar al tope)
                    $vidasARecuperar = $horasTranscurridas;
                    $user->current_lives = min($user->max_lives, $user->current_lives + $vidasARecuperar);
                    
                    // Actualizamos el tiempo: sumamos las horas exactas que hemos "consumido"
                    // para que no pierda los minutos sobrantes para la siguiente vida.
                    $user->last_life_recovery = $ultimaRecuperacion->addHours($vidasARecuperar);
                    $user->save();
                }
            } else {
                // Si tiene las vidas llenas, reseteamos el marcador de tiempo a null
                if ($user->last_life_recovery !== null) {
                    $user->last_life_recovery = null;
                    $user->save();
                }
            }
        }

        return $next($request);
    }
}