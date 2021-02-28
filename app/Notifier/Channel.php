<?php


namespace App\Notifier;


use App\Exceptions\NotSupportChannelException;
use App\Notifier\Channel\AliyunSms\AliyunSmsChannel;
use App\Notifier\Channel\DingTalk\DingTalkChannel;
use App\Notifier\Channel\NotifierEmail\NotifierEmailChannel;
use App\Notifier\Channel\WeCom\WeComChannel;

class Channel
{
    private $dsn;

    public function __construct(Dsn $dsn)
    {
        $this->dsn = $dsn;
    }

    public function getChannel(): string
    {
        switch ($this->dsn->getScheme()) {
            case 'email':
                switch ($this->dsn->getHost()) {
                    case 'smtp':
                        return NotifierEmailChannel::class;
                }

                break;

            case 'sms':
                switch ($this->dsn->getHost()) {
                    case 'aliyun':
                        return AliyunSmsChannel::class;
                }

                break;

            case 'chat':
                switch ($this->dsn->getHost()) {
                    case 'wecom':
                        return WeComChannel::class;

                    case 'dingtalk':
                        return DingTalkChannel::class;
                }

                break;

            default:

        }

        throw new NotSupportChannelException();
    }

    public function configuration(): array
    {
        return config(sprintf('notifier_channel.%s.%s.%s', $this->dsn->getScheme(), $this->dsn->getHost(), $this->dsn->getUser()));
    }
}
