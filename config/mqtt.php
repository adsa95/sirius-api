<?php

return [
    'host' => env('MQTT_HOST', null),
    'port' => env('MQTT_PORT', 1883),
    'client_id' => env('MQTT_CLIENT_ID', 'sirius-api'),
    'topic' => env('MQTT_TOPIC', 'sirius')
];
