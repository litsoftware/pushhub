<?php

namespace App\Notifications;

use App\Mail\NotifierMail;
use App\Notifier\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class UniNotification extends Notification
{
    use Queueable;

    private $channel;
    private $from;
    private $content;
    private $noticeId;

    /**
     * Create a new notification instance.
     *
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
        $this->noticeId = (string)Str::uuid();
    }

    public function getId(): string
    {
        return $this->noticeId;
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
    public function via(mixed $notifiable): array
    {
        return [$this->channel->getChannel()];
    }

    public function getChannelConfiguration(): array
    {
        return $this->channel->configurationFromDB();
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
            'sign' => $this->content['sign'],
        ];
    }

    public function toText(): string
    {
        return $this->content['content'];
    }

    public function toWeCom(): array
    {
        return $this->content['content'];
    }

    public function toDingTalk(): array
    {
        return $this->content['content'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NotifierMail
     */
    public function toMail(mixed $notifiable): NotifierMail
    {
        return new NotifierMail($this->content);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }
}
