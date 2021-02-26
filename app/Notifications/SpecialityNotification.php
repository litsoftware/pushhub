<?php

namespace App\Notifications;

use App\Mail\NotifierMail;
use App\Notifier\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SpecialityNotification extends Notification
{
    use Queueable;

    private $channel;
    private $from;
    private $content;

    /**
     * Create a new notification instance.
     *
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function from($from)
    {
        $this->from = $from;
    }

    public function getFrom()
    {
        return $this->from;
    }



    public function content(array $content)
    {
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [$this->channel->getChannel()];
    }

    public function getChannelConfiguration()
    {
        return $this->channel->configuration();
    }

    public function toSms(): string
    {
        return $this->content['content'];
    }

    public function toTmplSms(): array
    {
        return [
            'tmpl_id' => $this->content['tmpl_id'],
            'params' => $this->content['params'],
        ];
    }

    public function toText(): string
    {
        return $this->content['content'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NotifierMail
     */
    public function toMail($notifiable)
    {
        return new NotifierMail($this->content, $from);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
