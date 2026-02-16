<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateStreak
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $today = Carbon::today();
            $lastStreak = $user->last_streak_at ? Carbon::parse($user->last_streak_at)->startOfDay() : null;

            if (!$lastStreak) {
                // Primera vez que entra
                $user->streak = 1;
                $user->last_streak_at = now();
                $user->save();
            } else {
                $diff = $today->diffInDays($lastStreak);

                if ($diff === 1) {
                    // Entró al día siguiente: +1 racha
                    $user->streak += 1;
                    $user->last_streak_at = now();
                    $user->save();
                } elseif ($diff > 1) {
                    // Pasó más de un día: Reiniciar racha a 1
                    $user->streak = 1;
                    $user->last_streak_at = now();
                    $user->save();
                }
                // Si diff === 0, ya entró hoy, no hacemos nada.
            }
        }

        return $next($request);
    }
}