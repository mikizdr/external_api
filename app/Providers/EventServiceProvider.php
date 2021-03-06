<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CreateUserEvent' => [
            'App\Listeners\CreateUserEventListener',
            'App\Listeners\AttachOrganizationEventListener',
        ],
        'App\Events\AttachUserEvent' => [
            'App\Listeners\CheckAndAttachUserToOrganization',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
