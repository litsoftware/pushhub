<?php


namespace App\Notifier\Channel\NotifierEmail;


use App\Jobs\ChannelMailerJob;
use App\Notifications\SpecialityNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotifierEmailChannel
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
        if ($from = $notification->getFrom()) {
            if (isset($from['name']) && $from['name']) {
                $config['from']['name'] = $from['name'];
            }
            if (isset($from['address']) && $from['address']) {
                $config['from']['address'] = $from['address'];
            }
        }

        ChannelMailerJob::dispatch($config, $to->getEmail(), $notification->toMail($notifiable));
    }
}
