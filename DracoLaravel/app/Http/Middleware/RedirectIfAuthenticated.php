<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Clase RedirectIfAuthenticated
 * * Este middleware gestiona el comportamiento de las rutas de acceso (Login, Registro)
 * cuando el usuario ya dispone de una sesión activa. Su objetivo es evitar la
 * redundancia y redirigir al usuario a la zona principal de la aplicación.
 * * @author Marta
 */
class RedirectIfAuthenticated
{
    /**
     * Intercepta la petición para comprobar el estado de autenticación.
     * * Si el sistema detecta que el usuario ya está identificado, bloquea el acceso
     * a las páginas de invitados y lo redirige automáticamente a la ruta definida 
     * en el RouteServiceProvider (página principal).
     * * @author Marta
     * @param  \Illuminate\Http\Request  $request Petición entrante.
     * @param  \Closure  $next Siguiente capa en el ciclo de vida.
     * @param  string  ...$guards Diferentes "guardias" de autenticación configurados.
     * @return \Symfony\Component\HttpFoundation\Response Respuesta procesada o redirección.
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
