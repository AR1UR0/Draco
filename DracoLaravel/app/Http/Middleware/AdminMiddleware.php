<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

/**
* AdminMiddleware Class
* * Acts as a security layer (filter) that intercepts HTTP requests
* before they reach the controllers. Its function is to verify that the user
* is not only authenticated, but also has administrator privileges.
* * @author Marta
*/
class AdminMiddleware
{
    /**
    * Handles the incoming request.
    * Applies validation based on the user's role:
    * 1. Checks if an active session exists (Auth::check).
    * 2. Checks if the role ID corresponds to Administrator (role_id == 1).
    * @author Marta
    * @param \Illuminate\Http\Request $request Captured request.
    * @param \Closure $next Next step in the request lifecycle.
    * @return \Symfony\Component\HttpFoundation\Response Allowed response or security redirection.
    */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request); 
        }

        return redirect('/')->with('error', 'No tienes permiso para entrar aquí.');
    }
}