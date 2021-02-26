<?php


namespace App\Notifier\Channel\DingTalk;


use App\Notifications\SpecialityNotification;


class DingTalkChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     */
    public function send($notifiable, SpecialityNotification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('notifier')) {
            return;
        }

        $config = $notification->getChannelConfiguration();


    }
}
