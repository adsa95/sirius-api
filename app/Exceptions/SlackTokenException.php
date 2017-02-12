<?php declare(strict_types = 1);

namespace App\Exceptions;

class SlackTokenException extends SlackException
{
    public static function invalidToken(): SlackTokenException
    {
        return new static('Invalid Slack token.');
    }
}