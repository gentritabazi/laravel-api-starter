<?php

namespace Api\Users\Providers;

use Api\Users\Models\User;
use Api\Users\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Api\Users\Providers\UserEventServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Event service provider
        $this->app->register(UserEventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Observers
        User::observe(UserObserver::class);
    }
}
