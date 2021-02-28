<?php


namespace App\Notifier\Channel\WeCom\Messages;


/**
 * Class AbstractMessage
 *
 * @package App\Notifier\Channel\WeCom\Messages
 */
class AbstractMessage implements MessageInterface
{
    protected array $msg;

    public function toArray(): array
    {
        $this->buildMessage();
        return $this->msg;
    }

    public function toJson(): string
    {
        $this->buildMessage();
        return json_encode($this->msg);
    }
}
