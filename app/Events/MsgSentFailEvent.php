<?php

namespace App\Events;

use App\Notifications\UniNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MsgSentFailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UniNotification $notification;
    public string $reason;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UniNotification $notification, $reason = '')
    {
        $this->notification = $notification;
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
