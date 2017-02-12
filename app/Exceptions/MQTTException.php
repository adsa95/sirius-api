<?php declare(strict_types = 1);

namespace App\Exceptions;

use \RuntimeException;

class MQTTException extends RuntimeException
{
    public static function connectionFailed($host, $port)
    {
        $message = "Failed connecting to MQTT broker ($host:$port)";
        return new static($message);
    }
}