<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class TextContent
 *
 * @property string $content
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class TextContent
{
    public string $content;

    public function __construct($content)
    {
        $this->content = $content;
    }
}
