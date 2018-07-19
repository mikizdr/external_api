<?php

namespace App\Listeners;

use App\Events\AttachUserEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckAndAttachUserToOrganization
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
     * @param  AttachUserEvent  $event
     * @return void
     */
    public function handle(AttachUserEvent $event)
    {
        \Log::info('attach_existing_user_to_organization', ['user' => $event->user]);
    }
}
