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
            // Caso A: Si diff es 0 (mismo día), no entramos en los if y no hacemos nada.
        }

        return $next($request);
    }
}