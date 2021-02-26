<?php


namespace App\Notifier\Channel\WeCom;


use Illuminate\Support\ServiceProvider;

class WeComServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WeComChannel::class, function ($app) {
            return new WeComChannel();
        });
    }
}
