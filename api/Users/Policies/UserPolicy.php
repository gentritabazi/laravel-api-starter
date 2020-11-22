<?php

namespace Api\Users\Policies;

use Api\Users\Models\User;

class UserPolicy
{
    /**
     * Determine if the given user can be updated by the user.
     *
     * @param  \Api\Users\Models\User  $user
     * @param  \Api\Users\Models\User  $affectedUser
     * @return bool
     */
    public function update(User $user, User $affectedUser)
    {
        return $user->id === $affectedUser->id;
    }
}
