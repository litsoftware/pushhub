<?php


namespace App\Notifier\Channel\DingTalk\Messages;

use App\Notifier\Channel\DingTalk\Messages\Support\LinkContent;

/**
 * Class LinkMessage
 *
 * @property LinkContent $link
 *
 * @package App\Notifier\Channel\DingTalk\Messages
 */
final class LinkMessage extends AbstractMessage
{
    public string $msgtype = 'link';
    public LinkContent $link;

    public function __construct(LinkContent $link)
    {
        $this->link = $link;
    }
}
