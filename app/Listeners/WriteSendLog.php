<?php

namespace App\Listeners;

use App\Events\NewMessageEvent;
use App\Models\SendLog;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WriteSendLog
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
     * @param  NewMessageEvent  $event
     * @return void
     */
    public function handle(NewMessageEvent $event)
    {
        $n = $event->notification;
        SendLog::create([
            SendLog::REQUEST_ID => $n->getId(),
            SendLog::USER_ID => $n->user->{User::ID},
            SendLog::CONTENT => json_encode($n->data, JSON_PRETTY_PRINT),
            SendLog::STATUS => SendLog::STATUS_PENDING,
        ]);
    }
}
