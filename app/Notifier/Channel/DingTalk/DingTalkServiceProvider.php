<?php


namespace App\Notifier\Channel\DingTalk;


use Illuminate\Support\ServiceProvider;

class DingTalkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DingTalkChannel::class, function ($app) {
            return new DingTalkChannel();
        });
    }
}
