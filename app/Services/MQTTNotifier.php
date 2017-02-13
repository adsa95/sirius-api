<?php declare(strict_types = 1);

namespace App\Services;

// Helpers
use App\Helpers\MQTT;

// Models
use App\Models\Config;

class MQTTNotifier implements Notifier
{
    private $client;
    private $topic;

    public function __construct(MQTT $client, string $topic)
    {
        $this->client = $client;
        $this->topic = $topic;
    }

    public function new(Config $config)
    {
        $this->client->publish($this->topic, "new:{$config->sirius_id}");
    }

    public function update(Config $config)
    {
        $this->client->publish($this->topic, "update:{$config->sirius_id}");
    }

    public function delete(string $id)
    {
        $this->client->publish($this->topic, "delete:{$id}");
    }
}