<?php

namespace App\Providers;

use Illuminate\Mail\Mailer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('channel.mailer', function ($app, $parameters) {
            $smtpHost = data_get($parameters, 'host');
            $smtpPort = data_get($parameters, 'port');
            $smtpUsername = data_get($parameters, 'username');
            $smtpPassword = data_get($parameters, 'password');
            $smtpEncryption = data_get($parameters, 'encryption');

            $fromEmail = data_get($parameters, 'from.address');
            $fromName = data_get($parameters, 'from.name');

            $transport = new \Swift_SmtpTransport($smtpHost, $smtpPort);
            $transport->setUsername($smtpUsername);
            $transport->setPassword($smtpPassword);
            $transport->setEncryption($smtpEncryption);

            $swiftMailer = new \Swift_Mailer($transport);

            $mailer = new Mailer('channelMailer', $app->get('view'), $swiftMailer, $app->get('events'));
            $mailer->alwaysFrom($fromEmail, $fromName);
            $mailer->alwaysReplyTo($fromEmail, $fromName);

            return $mailer;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
