<?php

namespace App\Listeners;

use App\Events\EmailSent;

class EmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailSent  $event
     * @return void
     */
    public function handle(EmailSent $event)
    {
        echo "Test message";
    }
}
