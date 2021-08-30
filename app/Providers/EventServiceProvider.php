<?php

namespace App\Providers;

use App\Events\NewMessageEvent;
use App\Events\MsgSentSuccessEvent;
use App\Events\MsgSentFailEvent;
use App\Listeners\WriteSendLog;
use App\Listeners\UpdateSendLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewMessageEvent::class => [
            WriteSendLog::class,
        ],
        MsgSentSuccessEvent::class => [
            UpdateSendLog::class,
        ],
        MsgSentFailEvent::class => [
            UpdateSendLog::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
