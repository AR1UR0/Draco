<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está logueado Y su rol es 1 (admin)
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request); // Déjalo pasar
        }

        // Si no, mándalo a la página principal
        return redirect('/')->with('error', 'No tienes permiso para entrar aquí.');
    }
}