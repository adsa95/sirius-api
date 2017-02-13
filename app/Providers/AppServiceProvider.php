<?php

namespace App\Providers;

// Core
use Illuminate\Support\ServiceProvider;

// Observers
use App\Observers\ConfigObserver;

// Models
use App\Models\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Config::observe(ConfigObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
