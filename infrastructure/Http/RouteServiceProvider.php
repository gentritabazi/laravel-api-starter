<?php

namespace Infrastructure\Http;

use Illuminate\Routing\Router;
use Gentritabazi01\LarapiComponents\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);

        $router->pattern('id', '[0-9]+');

        parent::boot($router);
    }
}
