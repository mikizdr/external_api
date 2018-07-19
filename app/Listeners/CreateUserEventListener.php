<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Illuminate\Http\Request;

class CreateUserEventListener
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
     * @param  CreateUserEvent  $event
     * @return void
     */
    public function handle(CreateUserEvent $event)
    {
        \Log::info('create_user', ['email' => $event->email]);
        $user = User::create([
            'email'       => $event->email,
            'first_name'  => 'Lea',
            'last_name'   => 'Zdravkovic',
            'password'    => bcrypt('123456'),
            'user_id'     => '54kh3789kjh7984kjh79',
            'birth_date'  => '2018-07-01',
            'last_message_view'  => '2018-07-01',
            'pwd_change_date'  => '2018-07-01'
        ]);
        return $user;
    }
}
