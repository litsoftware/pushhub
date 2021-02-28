<?php


namespace App\Notifier\Channel\DingTalk;


use App\Notifications\UniNotification;


class DingTalkChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     */
    public function send($notifiable, UniNotification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('notifier')) {
            return;
        }

        $config = $notification->getChannelConfiguration();


    }
}
