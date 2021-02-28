<?php


namespace App\Notifier\Channel\DingTalk\Messages;


use App\Exceptions\InvalidArgumentException;

class Types
{
    const TEXT = 'text';
    const LINK = 'link';
    const MARKDOWN = 'markdown';
    const ACTION_CARD = 'actionCard';
    const FEED_CARD = 'feedCard';

    public static function check($msgType)
    {
        if (!in_array($msgType, [
            self::TEXT,
            self::LINK,
            self::MARKDOWN,
            self::ACTION_CARD,
            self::FEED_CARD
        ])) {
            throw new InvalidArgumentException();
        }
    }
}
