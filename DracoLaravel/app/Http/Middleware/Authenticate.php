<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
* Authenticate Class
* Middleware responsible for verifying global user authentication.
* Its main function is to intercept requests to protected routes and ensure
* that only users with an active session can proceed.
* @author Marta
*/
class Authenticate extends Middleware
{
    /**
    * Determines the redirect route when the user is not authenticated.
    * If the request expects a JSON response (such as an AJAX API call),
    * it does not redirect, but returns a 401 error. Otherwise, it redirects
    * automatically to the login form.
    * @author Marta
    * @param \Illuminate\Http\Request $request Incoming user request.
    * @return string|null Redirect route to the login or null for API responses.
    */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
