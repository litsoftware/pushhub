<?php


namespace App\Notifier\Channel\AliyunSms;


use App\Notifications\UniNotification;
use AlibabaCloud\Client\Exception\ClientException;
use Throwable;

class AliyunSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     * @throws ClientException
     * @throws Throwable
     */
    public function send($notifiable, UniNotification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('notifier')) {
            return;
        }

        $config = $notification->getChannelConfiguration();
        $data = $notification->toTmplSms();

        $client = new AliyunSmsClient($config);
        $client->send($to, $data);
    }
}
