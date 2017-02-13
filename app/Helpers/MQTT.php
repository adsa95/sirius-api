<?php
namespace App\Helpers;

// Core
use Log;
use Config;

// Exceptions
use App\Exceptions\MQTTException;

// MQTT
use Library\MQTT as MQTTClient;

class MQTT
{
    private $host;
    private $port;
    private $user;
    private $password;
    private $conn;
    private $connected = false;

    public function __construct(
        string $host,
        string $port,
        string $clientId,
        $user = null,
        $password = null
    ) {
        $this->user = $user;
        $this->password = $password;

        $this->conn = new MQTTClient($host, $port, $clientId);
    }

    public function publish(string $topic, string $message)
    {
        if (!$this->connected) {
            $this->connect();
        }

        $this->conn->publish($topic, $message);
        Log::debug("MQTT publish: $message");
    }

    private function connect()
    {
        if (!$this->conn->connect(true, null, $this->user, $this->password)) {
            throw MQTTException::connectionFailed($this->host, $this->port);
        }

        $this->connected = true;
    }
}