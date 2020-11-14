<?php

namespace Api\Users\Listeners;

class SendEmailWelcome
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;

        //
    }
}
