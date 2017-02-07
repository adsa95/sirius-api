<?php namespace App\Http\Middleware;

// Exceptions
use App\Exceptions\TokenException;


class RequireToken
{
    public function handle($request, \Closure $next)
    {
        if(!isset($_ENV['SIRIUS_TOKEN'])) throw new TokenException;

        $token = $_ENV['SIRIUS_TOKEN'];

        if(isset($_GET['token']) && strcmp($_GET['token'], $token) == 0){
            return $next($request);
        }else if($request->header('Authorization') !== null && substr_compare($request->header('Authorization'), $token, 7) === 0){
            return $next($request);
        }

        throw new TokenException;
    }
}
