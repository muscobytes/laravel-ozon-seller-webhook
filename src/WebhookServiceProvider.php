<?php

namespace Muscobytes\OzonSeller;

use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/ozonseller.php', 'ozonseller'
        );
    }


    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/ozonseller.php' => config_path('ozonseller.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
