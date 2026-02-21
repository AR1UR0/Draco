<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
* Kernel Class
* * It is the central core of DRACO's HTTP requests.
* Its function is to orchestrate the data flow, defining which filters (middlewares)
* are applied globally, which belong to the web group, and how they are nicknamed.
* Custom middlewares are used in the routes.
* * @author Marta
*/
class Kernel extends HttpKernel
{
    /**
    * Global Middleware Stack.
    * These filters are executed on ANY request to the server.
    * They include maintenance tasks, post size validation, and
    * string normalization (TrimStrings) developed by Marta.
    * @author Marta
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
    * Middleware groups by route type.
    * The 'web' group has been configured to manage sessions, cookies, and
    * CSRF security. The inclusion of 'UpdateStreak' is noteworthy, ensuring that the user's
    * streak is updated with each interaction with the website.
    * @author Marta
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
            \App\Http\Middleware\RestoreLives::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
    * Middleware Aliases.
    * These allow you to assign short names to complex classes. This is where you
    * register custom middlewares like 'admin', 'nocache', and 'streak'
    * for easy use in the routes file (web.php).
    * @author Marta
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
