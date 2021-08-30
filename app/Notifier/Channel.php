<?php


namespace App\Notifier;


use App\Exceptions\NotSupportChannelException;
use App\Notifier\Channel\AliyunSms\AliyunSmsChannel;
use App\Notifier\Channel\ChannelTypes;
use App\Notifier\Channel\DingTalk\DingTalkChannel;
use App\Notifier\Channel\NotifierEmail\NotifierEmailChannel;
use App\Notifier\Channel\QcloudSms\QcloudSmsChannel;
use App\Notifier\Channel\WeCom\WeComChannel;
use Illuminate\Support\Facades\Auth;

class Channel
{
    private Dsn $dsn;
    private string $type;

    public function __construct(Dsn $dsn)
    {
        $this->dsn = $dsn;
    }

    public function getChannel(): string
    {
        switch ($this->dsn->getScheme()) {
            case ChannelTypes::TypeEmail:
                $this->type = ChannelTypes::TypeEmail;
                switch ($this->dsn->getHost()) {
                    case 'smtp':
                        return NotifierEmailChannel::class;
                }

                break;

            case ChannelTypes::TypeSms:
                $this->type = ChannelTypes::TypeSms;
                switch ($this->dsn->getHost()) {
                    case 'aliyun':
                        return AliyunSmsChannel::class;

                    case 'qcloud':
                        return QcloudSmsChannel::class;
                }

                break;

            case ChannelTypes::TypeChat:
                $this->type = ChannelTypes::TypeChat;
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
        $configKey = sprintf('notifier_channel.%s.%s.%s', $this->dsn->getScheme(), $this->dsn->getHost(), $this->dsn->getUser());
        return config($configKey);
    }

    public function configurationFromDB(): array
    {
        $m = \App\Models\Channel::where('user_id', Auth::id())
            ->where(\App\Models\Channel::NAME, sprintf('%s@%s', $this->dsn->getUser(), $this->dsn->getHost()))
            ->where(\App\Models\Channel::TYPE, $this->type)
            ->orderBy(\App\Models\Channel::VERSION, 'desc')
            ->firstOrFail();

        return json_decode($m->{\App\Models\Channel::CONF}, true);
    }
}
