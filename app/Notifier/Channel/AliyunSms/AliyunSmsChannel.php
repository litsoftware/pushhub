<?php


namespace App\Notifier\Channel\AliyunSms;


use Illuminate\Support\Facades\Notification;

class AliyunSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     */
    public function send($notifiable, $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('notifier')) {
            return;
        }

        dd($to);
    }
}
