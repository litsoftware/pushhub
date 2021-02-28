<?php


namespace App\Notifier\Channel\WeCom\Messages;


/**
 * Class MarkdownMessage
 * @property string $content
 * @package App\Notifier\Channel\WeCom\Messages
 */
final class MarkdownMessage extends AbstractMessage
{
    public function buildMessage()
    {
        $this->msg = [
            'msgtype' => 'markdown',
            'markdown' => [
                'content' => $this->content,
            ],
        ];
    }
}
