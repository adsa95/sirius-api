<?php

return [
    'host' => env('MQTT_HOST', null),
    'port' => env('MQTT_PORT', 1883),
    'user' => env('MQTT_USER', null),
    'password' => env('MQTT_PASS', null),
    'client_id' => env('MQTT_CLIENT_ID', 'sirius-api'),
    'topic' => env('MQTT_TOPIC', 'sirius')
];
