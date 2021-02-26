<?php


namespace App\Notifier\Channel\WebHook;


use Illuminate\Support\ServiceProvider;

class WebHookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WebHookChannel::class, function ($app) {
            return new WebHookChannel();
        });
    }
}
