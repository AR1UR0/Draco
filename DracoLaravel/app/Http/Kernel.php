<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * Clase Kernel
 * * Es el núcleo central de las peticiones HTTP de DRACO.
 * Su función es orquestar el flujo de datos, definiendo qué filtros (middlewares)
 * se aplican de forma global, cuáles pertenecen al grupo web y cómo se apodan
 * los middlewares personalizados para ser usados en las rutas.
 * * @author Marta
 */
class Kernel extends HttpKernel
{
    /**
     * Stack de Middlewares Globales.
     * * Estos filtros se ejecutan en CUALQUIER petición al servidor.
     * Incluyen tareas de mantenimiento, validación de tamaño de posts y 
     * la normalización de cadenas (TrimStrings) desarrollada por Marta.
     * * @author Marta
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Grupos de Middlewares por tipo de ruta.
     * * Se ha configurado el grupo 'web' para gestionar sesiones, cookies y
     * seguridad CSRF. Se destaca la inclusión de 'UpdateStreak' para que la
     * racha del usuario se actualice en cada interacción con la web.
     * * @author Marta
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\UpdateStreak::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Aliases de Middlewares.
     * * Permiten asignar nombres cortos a clases complejas. Aquí es donde se
     * registra los middlewares personalizados como 'admin', 'nocache' y 'streak'
     * para utilizarlos fácilmente en el archivo de rutas (web.php).
     * * @author Marta
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'nocache' => \App\Http\Middleware\NoCache::class,
        'streak' => \App\Http\Middleware\UpdateStreak::class,
    ];
}
