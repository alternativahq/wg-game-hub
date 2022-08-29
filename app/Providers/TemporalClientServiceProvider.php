<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

class TemporalClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('temporal-client', function () {
            $serviceClient = ServiceClient::create(config('temporal.host') . ':' . config('temporal.port'));
            return WorkflowClient::create(serviceClient: $serviceClient);
        });
    }

    public function boot()
    {
    }
}
