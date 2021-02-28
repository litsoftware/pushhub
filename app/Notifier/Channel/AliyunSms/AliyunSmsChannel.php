<?php


namespace App\Notifier\Channel\AliyunSms;


use App\Notifications\SpecialityNotification;
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
    public function send($notifiable, SpecialityNotification $notification)
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
