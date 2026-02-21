<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
* RedirectIfAuthenticated Class
* This middleware manages the behavior of access routes (Login, Registration)
* when the user already has an active session. Its purpose is to avoid redundancy
* and redirect the user to the main area of ​​the application.
* @author Marta
*/
class RedirectIfAuthenticated
{
    /**
    * Intercepts the request to check the authentication status.
    * If the system detects that the user is already authenticated, it blocks access
    * to guest pages and automatically redirects them to the route defined
    * in the RouteServiceProvider (home page).
    * @author Marta
    * @param \Illuminate\Http\Request $request Incoming request.
    * @param \Closure $next Next layer in the lifecycle.
    * @param string ...$guards Different authentication "guards" configured.
    * @return \Symfony\Component\HttpFoundation\Response Response processed or redirected.
    */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
