<?php

namespace Api\Users\Observers;

use Api\Users\Models\User;
use Infrastructure\Abstracts\Observer;

class UserObserver extends Observer
{
    /**
     * Handle the User "created" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "forceDeleted" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
