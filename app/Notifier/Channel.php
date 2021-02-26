<?php


namespace App\Notifier;


use App\Notifier\Channel\NotifierEmail\NotifierEmailChannel;
use Illuminate\Support\Str;

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
                switch ($this->dsn->getUser()) {
                    case 'aliyun':
                    case 'netease':
                        return NotifierEmailChannel::class;
                }

                break;
        }
    }

    public function configuration(): array
    {
        return config(sprintf('notifier_channel.%s.%s.%s', $this->dsn->getScheme(), $this->dsn->getUser(), $this->dsn->getHost()));
    }
}
