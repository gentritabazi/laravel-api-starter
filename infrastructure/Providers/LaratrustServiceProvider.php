<?php

namespace Infrastructure\Providers;

use Laratrust\LaratrustServiceProvider as MainLaratrustServiceProvider;

class LaratrustServiceProvider extends MainLaratrustServiceProvider
{
    /**
     * Register permissions to Laravel Gate
     *
     * @return void
     */
    protected function registerPermissionsToGate()
    {
        // Don't remove this.
    }
}
