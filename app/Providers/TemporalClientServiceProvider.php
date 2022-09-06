<?php

namespace App\Providers;

use Http;
use Illuminate\Support\ServiceProvider;
use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

class TemporalClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('temporal-client', function () {
            $host = config('temporal.host');
            $host = $host . config('temporal.port') ? ':' . config('temporal.port') : '';
            $serviceClient = ServiceClient::create($host);
            return WorkflowClient::create(serviceClient: $serviceClient);
        });
    }

    public function boot()
    {
    }
}
