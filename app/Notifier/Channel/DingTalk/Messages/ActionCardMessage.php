<?php


namespace App\Notifier\Channel\DingTalk\Messages;


use App\Notifier\Channel\DingTalk\Messages\Support\ActionCardContent;

/**
 * Class ActionCardMessage
 *
 * @property ActionCardContent $actionCard
 *
 * @package App\Notifier\Channel\DingTalk\Messages
 */
final class ActionCardMessage extends AbstractMessage
{
    public string $msgtype = 'actionCard';

    public ActionCardContent $actionCard;

    public function __construct(ActionCardContent $actionCard)
    {
        $this->actionCard = $actionCard;
    }
}
