<?php


namespace App\Notifier\Channel\WeCom\Messages;


use App\Exceptions\InvalidArgumentException;

class Types
{
    const TEXT = 'text';
    const MARKDOWN = 'markdown';
    const IMAGE = 'image';
    const NEWS = 'news';
    const FILE = 'file';

    public static function check($type)
    {
        $allTypes = [
            self::TEXT,
            self::MARKDOWN,
            self::IMAGE,
            self::NEWS,
            self::FILE,
        ];

        if (!in_array($type, $allTypes)) {
            throw new InvalidArgumentException();
        }
    }
}
