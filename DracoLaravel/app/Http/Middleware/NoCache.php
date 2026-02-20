<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Clase NoCache
 * * Este middleware de seguridad se encarga de gestionar las cabeceras HTTP de respuesta
 * para evitar que el navegador almacene copias locales (caché) de las páginas visitadas.
 * Es crítico para proteger la privacidad del usuario tras el cierre de sesión.
 * * @author Marta
 */
class NoCache
{
    /**
     * Intercepta la respuesta y aplica directivas de control de caché.
     * * Modifica las cabeceras de la respuesta para asegurar que:
     * 1. No se almacene información sensible en el disco (no-store).
     * 2. Se fuerce la revalidación con el servidor en cada petición (must-revalidate).
     * 3. Se establezca una fecha de expiración en el pasado para invalidar cualquier copia.
     * * @author Marta
     * @param  \Illuminate\Http\Request  $request Petición entrante.
     * @param  \Closure  $next Siguiente capa del ciclo de vida.
     * @return \Symfony\Component\HttpFoundation\Response Respuesta con cabeceras de seguridad aplicadas.
     */
    public function handle($request, Closure $next)
{
    $response = $next($request);
    return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}
