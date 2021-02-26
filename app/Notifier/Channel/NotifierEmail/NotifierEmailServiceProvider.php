<?php


namespace App\Notifier\Channel\NotifierEmail;


use Illuminate\Support\ServiceProvider;

class NotifierEmailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(NotifierEmailChannel::class, function ($app) {
            return new NotifierEmailChannel();
        });
    }
}
