<?php declare(strict_types = 1);

namespace App\Providers;

// Core
use Illuminate\Support\ServiceProvider;

// Helpers
use App\Helpers\MQTT;

// Services
use App\Services\Notifier;
use App\Services\MQTTNotifier;

class MQTTServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Notifier::class, function($app) {
            $config = $app->make('config');

            $mqtt = new MQTT(
                $config->get('mqtt.host'),
                $config->get('mqtt.port'),
                $config->get('mqtt.client_id'),
                $config->get('mqtt.user'),
                $config->get('mqtt.password')
            );

            return new MQTTNotifier($mqtt, $config->get('mqtt.topic'));
        });
    }

    public function provides(): array
    {
        return [Notifier::class];
    }
}
