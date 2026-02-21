<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
* RestoreLives Class
* This middleware manages the passive life regeneration system.
* It checks the time elapsed since the last health loss and
* automatically grants lives to the user (1 life per hour) until
* the configured maximum limit is reached.
* @author Marta
*/
class RestoreLives
{

    /**
     * Handles an incoming request.
     * * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // We only act if the user is logged in and is NOT a Plus user 
        if (Auth::check() && !Auth::user()->is_plus) {
            $user = Auth::user();
            
            // If it has fewer lives than the maximum
            if ($user->current_lives < $user->max_lives) {
                $ahora = Carbon::now();
                /**
                * Timer initialization:
                * If the user has lost lives but there is no record of when,
                * we set the current time as the starting point.
                */
                if (!$user->last_life_recovery) {
                    $user->last_life_recovery = $ahora;
                    $user->save();
                }

                $ultimaRecuperacion = $user->last_life_recovery;
                // We calculate how many full hours have passed
                $horasTranscurridas = $ahora->diffInHours($ultimaRecuperacion);

                if ($horasTranscurridas >= 1) {
                    // We calculate how many lives we add up (maximum until we reach the limit)
                    $vidasARecuperar = $horasTranscurridas;
                    $user->current_lives = min($user->max_lives, $user->current_lives + $vidasARecuperar);
                    
                    /**
                    * Time marker update:
                    * We don't reset to 'now()', but instead add the consumed hours to the original record.
                    * This preserves the remaining minutes for the next life's recovery.
                    */
                    $user->last_life_recovery = $ultimaRecuperacion->addHours($vidasARecuperar);
                    $user->save();
                }
            } else {
                /**
                * State cleanup:
                * If lives are full, we ensure the timer is null
                * so the process restarts cleanly the next time the user fails.
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