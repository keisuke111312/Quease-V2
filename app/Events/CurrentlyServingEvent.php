<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrentlyServingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $professorId;
    public $position;

    public function __construct($professorId, $position)
    {
        $this->professorId = $professorId;
        $this->position = $position;
    }

    public function broadcastOn()
    {
        return new Channel('professor-serving');
    }

    public function broadcastAs()
    {
        return 'currentlyServing.updated';
    }
}
