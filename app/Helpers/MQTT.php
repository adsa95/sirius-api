<?php
namespace App\Helpers;

// Core
use App\Exceptions\MQTTException;
use Config;

// MQTT
use Library\MQTT as MQTTClient;

class MQTT
{
    private $conn;

    public function __construct(string $host, string $port, string $clientId)
    {
        $this->conn = new MQTTClient($host, $port, $clientId);

        if (!$this->conn->connect()) {
            throw MQTTException::connectionFailed($host, $port);
        }
    }

    public function publish(string $topic, string $message)
    {
            $this->conn->publish($topic, $message);
    }
}