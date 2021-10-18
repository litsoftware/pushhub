<?php

namespace App\Notifications;

use App\Mail\NotifierMail;
use App\Models\User;
use App\Notifier\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UniNotification extends Notification
{
    use Queueable;

    public Channel $channel;
    public User|null $user = null;
    Public mixed $data = null;

    private $from;
    private $content;
    private $noticeId;
    private $reason;

    public function setData(mixed $data) {
        $this->data = $data;
    }

    /**
     * Create a new notification instance.
     *
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
        $this->noticeId = (string)Str::uuid();
        $this->user = Auth::user();
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
        return $this->channel->configurationFromDB($this->user->{User::ID});
    }

    public function toSms(): string
    {
        return $this->content['content'];
    }

    public function toTmplSms(): array
    {
        return [
            'tmpl_id' => data_get($this->content, 'tmpl_id'),
            'params' => data_get($this->content, 'params'),
            'sign' => data_get($this->content, 'sign'),
        ];
    }

    public function toText(): string
    {
        return data_get($this->content, 'content');
    }

    public function toWeCom(): array
    {
        return data_get($this->content, 'content');
    }

    public function toDingTalk(): array
    {
        return data_get($this->content, 'content');
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

    function getReason(): string {
        return (string)$this->reason;
    }

    function setReason(string $s) {
        $this->reason = $s;
    }
}
