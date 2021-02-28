<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class singleActionCard
 *
 * @property string $title
 * @property string $text
 * @property string $hideAvatar
 * @property string $btnOrientation
 * @property array<Btn> $btns
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class SingleActionCardContent
{
    public string $title;
    public string $text;
    public string $hideAvatar;
    public string $btnOrientation;
    public array $btns;

    public function __construct(string $title, string $text, string $hideAvatar, array $btns, string $btnOrientation = '0')
    {
        $this->title = $title;
        $this->text = $text;
        $this->hideAvatar = $hideAvatar;
        $this->btns = $btns;
        $this->btnOrientation = $btnOrientation;
    }
}
