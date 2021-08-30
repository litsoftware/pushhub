<?php

namespace App\Listeners;

use App\Events\MsgSentFailEvent;
use App\Events\MsgSentSuccessEvent;
use App\Models\SendLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSendLog
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
     * @param  MsgSentSuccessEvent | MsgSentFailEvent  $event
     * @return void
     */
    public function handle(MsgSentSuccessEvent | MsgSentFailEvent $event)
    {
        $n = $event->notification;
        $query = SendLog::where(SendLog::USER_ID, $n->user->{User::ID})
            ->where(SendLog::REQUEST_ID, $n->getId());

        if ($event instanceof MsgSentSuccessEvent) {
            $query->update([
                SendLog::STATUS => SendLog::STATUS_SUCCESS,
                SendLog::SUCCESS_AT => new Carbon(),
            ]);
        }

        if ($event instanceof MsgSentFailEvent) {
            $query->update([
                SendLog::STATUS => SendLog::STATUS_FAIL,
                SendLog::FAIL_AT => new Carbon(),
                SendLog::FAIL_REASON => $n->getReason(),
            ]);
        }
    }
}
