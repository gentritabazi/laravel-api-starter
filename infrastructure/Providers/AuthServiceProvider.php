<?php

namespace Infrastructure\Providers;

use Api\Users\Policies\UserPolicy;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes(function ($router) {
            $router->forAccessTokens();
            // Uncomment for allowing personal access tokens
            // $router->forPersonalAccessTokens();
            $router->forTransientTokens();
        });

        Passport::tokensExpireIn(Carbon::now()->addMinutes(1440));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));

        Gate::define('update-user', [UserPolicy::class, 'update']);
    }
}
