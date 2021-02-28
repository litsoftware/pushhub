<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class At
 *
 * @property bool $isAtAll
 * @property array<string> $atMobiles
 *
 * @package App\Notifier\Channel\DingTalk\Messages
 */
class At
{
    public bool $isAtAll;
    public array $atMobiles;

    public function __construct(bool $isAtAll = false, array $atMobiles = [])
    {
        $this->isAtAll = $isAtAll;
        $this->atMobiles = $atMobiles;
    }
}
