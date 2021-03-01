<?php


namespace App\Notifier\Channel\QcloudSms;


use Illuminate\Support\ServiceProvider;

class QcloudSmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QcloudSmsChannel::class, function ($app) {
            return new QcloudSmsChannel();
        });
    }
}
