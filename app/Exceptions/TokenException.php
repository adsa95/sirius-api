<?php namespace App\Exceptions;

use \RuntimeException;

class TokenException extends RuntimeException
{
    public static function noTokenConfigured(): TokenException
    {
        return new static('No access token configured.');
    }

    public static function invalidToken(): TokenException
    {
        return new static('Invalid access token.');
    }
}
