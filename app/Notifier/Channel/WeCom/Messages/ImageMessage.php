<?php


namespace App\Notifier\Channel\WeCom\Messages;


/**
 * Class ImageMessage
 *
 * @property string $imageData  图片内容的base64编码
 * @property string $hash   图片内容（base64编码前）的md5值
 *
 * @package App\Notifier\Channel\WeCom\Messages
 */
final class ImageMessage extends AbstractMessage
{
    public function buildMessage()
    {
        $this->msg = [
            'msgtype' => 'image',
            'image' => [
                'base64' => $this->imageData,
                'md5' => $this->hash,
            ],
        ];
    }
}
