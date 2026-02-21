<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Clase RestoreLives
 * * Este middleware gestiona el sistema de regeneración pasiva de vidas.
 * Verifica el tiempo transcurrido desde la última pérdida de salud y 
 * otorga vidas automáticamente al usuario (1 vida por cada hora) hasta
 * alcanzar el límite máximo configurado.
 * * @author Marta
 */
class RestoreLives
{

    /**
     * Maneja una solicitud entrante.
     * * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Solo actuamos si el usuario está logueado y NO es Plus 
        if (Auth::check() && !Auth::user()->is_plus) {
            $user = Auth::user();
            
            // Si tiene menos vidas que el máximo
            if ($user->current_lives < $user->max_lives) {
                $ahora = Carbon::now();
                /**
                 * Inicialización del temporizador:
                 * Si el usuario ha perdido vidas pero no tiene registro de cuándo,
                 * establecemos el momento actual como punto de partida.
                 */
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
                    
                    /**
                     * Actualización del marcador de tiempo:
                     * No reseteamos a 'now()', sino que sumamos las horas consumidas al registro original.
                     * Esto preserva los minutos sobrantes para la recuperación de la siguiente vida.
                     */
                    $user->last_life_recovery = $ultimaRecuperacion->addHours($vidasARecuperar);
                    $user->save();
                }
            } else {
                /**
                 * Limpieza de estado:
                 * Si las vidas están llenas, nos aseguramos de que el temporizador sea null
                 * para que el proceso se reinicie limpiamente la próxima vez que el usuario falle.
                 */
                if ($user->last_life_recovery !== null) {
                    $user->last_life_recovery = null;
                    $user->save();
                }
            }
        }

        return $next($request);
    }
}