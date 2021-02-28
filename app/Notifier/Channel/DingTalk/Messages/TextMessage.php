<?php


namespace App\Notifier\Channel\DingTalk\Messages;


use App\Notifier\Channel\DingTalk\Messages\Support\At;
use App\Notifier\Channel\DingTalk\Messages\Support\AtTrait;
use App\Notifier\Channel\DingTalk\Messages\Support\TextContent;

/**
 * Class TextMessage
 *
 * @property TextContent $text
 *
 * @package App\Notifier\Channel\DingTalk\Messages
 */
final class TextMessage extends AbstractMessage
{
    use AtTrait;

    public TextContent $text;
    public string $msgtype = 'text';

    public function __construct(TextContent $text, At $at)
    {
        $this->text = $text;
        $this->at = $at;
    }
}
