<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Http\Request;

class CreateUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    private $email;
    /**
     * @var Request
     */
    private $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, Request $request)
    {
        $this->email = $email;
        $this->request = $request;
    }

}
