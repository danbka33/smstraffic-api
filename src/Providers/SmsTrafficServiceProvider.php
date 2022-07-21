<?php

namespace Danbka33\SmsTrafficApi\Providers;

use Danbka33\SmsTrafficApi\Client;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\ServiceProvider;

class SmsTrafficServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client(
                config('sms-traffic.login'),
                config('sms-traffic.password'),
                config('sms-traffic.originator')
            );
        });
    }

    public function boot(ConfigRepository $configRepository): void
    {
        $this->publishes([
            __DIR__.'/../config/sms-traffic.php' => $this->app->configPath().'/sms-traffic.php',
        ], 'sms-traffic-config');
    }

}