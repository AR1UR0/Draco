<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* NoCache Class
* This security middleware manages HTTP response headers
* to prevent the browser from storing local copies (caches) of visited pages.
* It is critical for protecting user privacy after logout.
* @author Marta
*/
class NoCache
{
    /**
    * Intercepts the response and applies cache control policies.
    * Modifies the response headers to ensure that:
    * 1. Sensitive information is not stored on disk (no-store).
    * 2. Revalidation with the server is enforced on each request (must-revalidate).
    * 3. An expiration date is set in the past to invalidate any copies.
    * @author Marta
    * @param \Illuminate\Http\Request $request Incoming request.
    * @param \Closure $next Next layer of the lifecycle.
    * @return \Symfony\Component\HttpFoundation\Response Response with security headers applied.
    */
    public function handle($request, Closure $next)
{
    $response = $next($request);
    return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}
