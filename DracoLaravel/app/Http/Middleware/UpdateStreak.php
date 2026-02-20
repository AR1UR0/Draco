<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Clase UpdateStreak
 * * Este middleware gestiona el sistema de "Rachas" (Streaks) del proyecto DRACO.
 * Se encarga de monitorizar la frecuencia de acceso del usuario y actualizar
 * automáticamente su contador de días consecutivos o reiniciarlo si se detecta
 * una interrupción en la actividad.
 * * @author Marta
 */
class UpdateStreak
{
    /**
     * Procesa la racha del usuario en cada petición autenticada.
     * * Utiliza la librería Carbon para realizar comparaciones precisas entre fechas:
     * - Caso A: Acceso en el mismo día (No ocurre nada).
     * - Caso B: Acceso al día siguiente (Incrementa la racha +1).
     * - Caso C: Acceso tras un periodo de inactividad (Reinicia la racha a 1).
     * * @author Marta
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
        public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $today = Carbon::today();
            // Convertimos la fecha de la DB a Carbon para comparar
            $lastStreakDate = Carbon::parse($user->last_streak_at)->startOfDay();

            $diff = $today->diffInDays($lastStreakDate);

            if ($diff === 1) {
                // Caso B: Entró al día siguiente exacto
                $user->streak += 1;
                $user->last_streak_at = now();
                $user->save();
            } elseif ($diff > 1) {
                // Caso C: Racha rota (pasaron 2 o más días)
                $user->streak = 1;
                $user->last_streak_at = now();
                $user->save();
            }
            // Caso A: Si diff es 0, el usuario ya ha accedido hoy, por lo que se mantiene la racha.
        }

        return $next($request);
    }
}