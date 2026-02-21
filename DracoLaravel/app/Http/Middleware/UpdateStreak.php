<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
* UpdateStreak Class
* This middleware manages the "Streaks" system of the DRACO project.
* It monitors the user's access frequency and automatically updates
* their consecutive days counter or resets it if an interruption in activity is detected.
* @author Marta
*/
class UpdateStreak
{
    /**
    * Processes the user's streak on each authenticated request.
    * Uses the Carbon library to perform accurate date comparisons:
    * - Case A: Access on the same day (Nothing happens).
    * - Case B: Access the next day (Increments the streak by 1).
    * - Case C: Access after a period of inactivity (Resets the streak to 1).
    * * @author Marta
    * @param \Illuminate\Http\Request $request
    * @param \Closure $next
    * @return mixed
    */
        public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $today = Carbon::today();
            // We convert the database date to Carbon for comparison
            $lastStreakDate = Carbon::parse($user->last_streak_at)->startOfDay();

            $diff = $today->diffInDays($lastStreakDate);

            if ($diff === 1) {
                // Case B: He entered the exact next day
                $user->streak += 1;
                $user->last_streak_at = now();
                $user->save();
            } elseif ($diff > 1) {
                // Case C: Streak broken (2 or more days have passed)
                $user->streak = 1;
                $user->last_streak_at = now();
                $user->save();
            }
            // Case A: If diff is 0, the user has already logged in today, so the streak continues.
        }

        return $next($request);
    }
}