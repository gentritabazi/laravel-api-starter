<?php

namespace Infrastructure\Providers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        // $this->configureRateLimiting();

        Route::pattern('id', '[0-9]+');
        
        parent::boot();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $extraRoutes = config('larapi.extra_routes');

        $highLevelParts = array_map(function ($namespace) {
            return glob(sprintf('%s%s*', $namespace, DIRECTORY_SEPARATOR), GLOB_ONLYDIR);
        }, config('larapi.extra_routes_namespaces'));

        foreach ($highLevelParts as $part => $partComponents) {
            foreach ($partComponents as $componentRoot) {
                $component = substr($componentRoot, strrpos($componentRoot, DIRECTORY_SEPARATOR) + 1);

                $namespace = sprintf(
                    '%s\\%s\\Controllers',
                    $part,
                    $component
                );

                foreach ($extraRoutes as $routeName => $route) {
                    $path = sprintf('%s/%s.php', $componentRoot, $routeName);

                    if (!file_exists($path)) {
                        continue;
                    }
                    
                    $namespace = sprintf(
                        '%s\\%s\\'. $route['namespace'],
                        $part,
                        $component
                    );

                    $router->group([
                        'middleware' => $route['middleware'],
                        'namespace' => $namespace,
                        'prefix' => $route['prefix']
                    ], function ($router) use ($path) {
                        require $path;
                    });
                }
            }
        }
    }
}
