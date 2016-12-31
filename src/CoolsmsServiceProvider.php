<?php

namespace NotificationChannels\Coolsms;

use NotificationChannels\Coolsms\Coolsms;
use Illuminate\Support\ServiceProvider;

class CoolsmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(CoolsmsChannel::class)
            ->needs(Coolsms::class)
            ->give(function () {
                $config = $this->app['config']['services.coolsms'];

                return new Coolsms($config);
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
