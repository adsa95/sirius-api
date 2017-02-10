<?php
namespace App\Helpers;

// Core
use Config;
use Illuminate\Support\Facades\Log;

// MQTT
use Library\MQTT as MQTTClient;

class MQTT
{
    public static function send($message)
    {
        $conn = new MQTTClient(
            Config::get('mqtt.host'),
            Config::get('mqtt.port'),
            uniqid()); // Use uniqid to get a unique connection name

        if ($conn->connect()) {
            $conn->publish('sirius', $message);
            $conn->close();

            Log::debug('Sent message to sirius-server: '.$message);

            return true;
        } else {
            return false;
        }

    }
}