<?php

namespace Api\Users\Events;

use Api\Users\Models\User;
use Infrastructure\Abstracts\Event;

class UserWasCreated extends Event
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
