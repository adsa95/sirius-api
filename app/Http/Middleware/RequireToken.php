<?php namespace App\Http\Middleware;

// Core
use Config;

// Exceptions
use App\Exceptions\TokenException;

class RequireToken
{
    public function handle($request, \Closure $next)
    {
        $token = Config::get('access.token');

        if ($token === null) {
            throw TokenException::noTokenConfigured();
        }

        $supplied = null;

        // GET-parameter
        if ($request->has('token')) {
            $supplied = $request->input('token');

        } elseif ($supplied = $request->header('Authorization')) {
            $supplied = mb_substr($supplied, mb_strlen('Bearer: '));
        }

        if ($supplied !== $token) {
            throw TokenException::invalidToken();
        }

        return $next($request);
    }
}
