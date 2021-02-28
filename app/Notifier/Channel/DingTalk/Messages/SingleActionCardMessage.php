<?php


namespace App\Notifier\Channel\DingTalk\Messages;


use App\Notifier\Channel\DingTalk\Messages\Support\SingleActionCardContent;

/**
 * Class SingleActionCardMessage
 * @package App\Notifier\Channel\DingTalk\Messages
 */
final class SingleActionCardMessage extends AbstractMessage
{
    public string $msgtype = 'actionCard';

    public SingleActionCardContent $actionCard;

    public function __construct(SingleActionCardContent $actionCard)
    {
        $this->actionCard = $actionCard;
    }
}
