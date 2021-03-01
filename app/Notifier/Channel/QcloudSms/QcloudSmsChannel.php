<?php


namespace App\Notifier\Channel\QcloudSms;


use App\Notifications\UniNotification;

class QcloudSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     * @throws \Throwable
     */
    public function send($notifiable, UniNotification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('notifier')) {
            return;
        }

        $config = $notification->getChannelConfiguration();
        $data = $notification->toTmplSms();

        $client = new QcloudClient($config);
        $client->send($to, $data);
    }
}
