<?php declare(strict_types = 1);

namespace App\Exceptions;

/**
 * Created by Johan Vester
 * johan@nicknamed.se
 *
 * Date: 2017-02-12
 *
 * (c) 2016 Nicknamed
 */

class SlackTokenException extends SlackException
{
    public static function invalidToken(): SlackTokenException
    {
        return new static('Invalid Slack token.');
    }
}