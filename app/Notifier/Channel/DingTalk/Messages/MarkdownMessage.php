<?php


namespace App\Notifier\Channel\DingTalk\Messages;

use App\Notifier\Channel\DingTalk\Messages\Support\At;
use App\Notifier\Channel\DingTalk\Messages\Support\AtTrait;
use App\Notifier\Channel\DingTalk\Messages\Support\MarkdownContent;

/**
 * Class MarkdownMessage
 *
 * @property MarkdownContent $markdown
 *
 * @package App\Notifier\Channel\DingTalk\Messages
 */
final class MarkdownMessage extends AbstractMessage
{
    use AtTrait;

    public MarkdownContent $markdown;
    public string $msgtype = 'markdown';

    public function __construct(MarkdownContent $markdown, At $at)
    {
        $this->markdown = $markdown;
        $this->at = $at;
    }
}
