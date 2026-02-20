<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Clase Authenticate
 * * Middleware encargado de verificar la autenticación global de los usuarios.
 * Su función principal es interceptar peticiones a rutas protegidas y asegurar
 * que solo los usuarios con una sesión activa puedan proceder.
 * * @author Marta
 */
class Authenticate extends Middleware
{
    /**
     * Determina la ruta de redirección cuando el usuario no está autenticado.
     * * Si la petición espera una respuesta JSON (como una llamada AJAX de la API), 
     * no redirige, sino que devuelve un error 401. En caso contrario, redirige 
     * automáticamente al formulario de inicio de sesión.
     * * @author Marta
     * @param  \Illuminate\Http\Request  $request Petición entrante del usuario.
     * @return string|null Ruta de redirección al login o null para respuestas API.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
