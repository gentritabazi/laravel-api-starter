<?php

namespace Api\Users\Providers;

use Api\Users\Events\UserWasCreated;
use Api\Users\Events\UserWasDeleted;
use Api\Users\Events\UserWasUpdated;
use Api\Users\Listeners\SendEmailWelcome;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class UserEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserWasCreated::class => [
            SendEmailWelcome::class
        ],

        UserWasUpdated::class => [
            //
        ],

        UserWasDeleted::class => [
            //
        ]
    ];
}
