<?php


namespace App\Notifier\Channel\WeCom\Messages;

/**
 * Class FileMessage
 *
 * @property string $mediaId
 *
 * @package App\Notifier\Channel\WeCom\Messages
 */
class FileMessage extends AbstractMessage
{
    public function buildMessage()
    {
        $this->msg = [
            'msgtype' => 'file',
            'file' => [
                'media_id' => $this->mediaId
            ],
        ];
    }
}
