<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Mailer;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Livewire\Component;

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
        Component::macro('notify', function ($message) {
            $this->dispatchBrowserEvent('notify', $message);
        });

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) return;

            $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($thing) {
                    return '"'.$thing.'"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });
    }
}
