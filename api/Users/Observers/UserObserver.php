<?php

namespace Api\Users\Observers;

use Api\Users\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function afterCommitCreated(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function afterCommitUpdated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function afterCommitDeleted(User $user)
    {
        //
    }

    /**
     * Handle the User "forceDeleted" event.
     *
     * @param  \Api\Users\Models\User  $user
     * @return void
     */
    public function afterCommitForceDeleted(User $user)
    {
        //
    }
}
