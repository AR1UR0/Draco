<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

/**
 * Clase AdminMiddleware
 * * Actúa como una capa de seguridad (filtro) que intercepta las peticiones HTTP
 * antes de que lleguen a los controladores. Su función es verificar que el usuario
 * no solo esté autenticado, sino que además posea privilegios de administrador.
 * * @author Marta
 */
class AdminMiddleware
{
    /**
     * Gestiona la petición entrante.
     * * Aplica una validación basada en el rol del usuario:
     * 1. Verifica si existe una sesión activa (Auth::check).
     * 2. Comprueba si el identificador de rol corresponde al Administrador (role_id == 1).
     * * @author Marta
     * @param  \Illuminate\Http\Request  $request Petición capturada.
     * @param  \Closure  $next Siguiente eslabón en el ciclo de vida de la petición.
     * @return \Symfony\Component\HttpFoundation\Response Respuesta permitida o redirección de seguridad.
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request); 
        }

        return redirect('/')->with('error', 'No tienes permiso para entrar aquí.');
    }
}