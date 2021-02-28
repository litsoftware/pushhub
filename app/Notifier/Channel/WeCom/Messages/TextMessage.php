<?php


namespace App\Notifier\Channel\WeCom\Messages;


/**
 * Class TextMessage
 * @property string $content
 * @property array<string> $mentionedList
 * @property array<string> $mentionedMobileList
 * @package App\Notifier\Channel\WeCom\Messages
 */
final class TextMessage extends AbstractMessage
{
    public function buildMessage()
    {
        $this->msg = [
            'msgtype' => 'text',
            'text' => [
                'content' => $this->content,
                'mentioned_list' => $this->mentionedList,
                'mentioned_mobile_list' => $this->mentionedMobileList,
            ],
        ];
    }
}
