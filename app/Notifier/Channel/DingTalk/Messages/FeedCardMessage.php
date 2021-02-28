<?php


namespace App\Notifier\Channel\DingTalk\Messages;

use App\Notifier\Channel\DingTalk\Messages\Support\FeedCardContent;

/**
 * Class FeedCardMessage
 *
 * @property FeedCardContent $feedCard
 *
 * @package App\Notifier\Channel\DingTalk\Messages
 */
final class FeedCardMessage extends AbstractMessage
{
    public string $msgtype = 'feedCard';
    public FeedCardContent $feedCard;

    public function __construct(FeedCardContent $feedCard)
    {
        $this->feedCard = $feedCard;
    }
}
