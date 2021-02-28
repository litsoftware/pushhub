<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class feedCardContent
 *
 * @property array<Link> $links
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class FeedCardContent
{
    public array $links;

    public function __construct(array $links)
    {
        $this->links = $links;
    }
}
