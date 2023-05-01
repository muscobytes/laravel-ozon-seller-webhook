<?php

namespace Muscobytes\OzonSeller\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class WebhookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/ozonseller.php', 'ozonseller'
        );
    }


    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/ozonseller.php' => config_path('ozonseller.php'),
            ]);
        }

        Route::pattern('client_id', '[0-9]+');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
    }
}
