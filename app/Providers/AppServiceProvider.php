<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'development')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceRootUrl(config('app.url'));
        if ($this->app->environment('production', 'development')) {
            $this->app['request']->server->set('HTTPS', 'on'); // pagination https
            URL::forceScheme('https'); // app https
            \Illuminate\Pagination\AbstractPaginator::currentPathResolver(function () {
                /** @var \Illuminate\Routing\UrlGenerator $url */
                $url = app('url');
                return $url->current();
            });
        }
    }
}
