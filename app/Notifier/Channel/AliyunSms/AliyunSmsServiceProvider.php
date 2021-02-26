<?php


namespace App\Notifier\Channel\AliyunSms;


use Illuminate\Support\ServiceProvider;

class AliyunSmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AliyunSmsChannel::class, function ($app) {
            return new AliyunSmsChannel();
        });
    }
}
