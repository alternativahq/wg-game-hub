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
            $port = config('temporal.port') ? ':' . config('temporal.port') : '';
            $host = "{$host}{$port}";
            $serviceClient = ServiceClient::create($host);
            return WorkflowClient::create(serviceClient: $serviceClient);
        });
    }

    public function boot()
    {
    }
}
