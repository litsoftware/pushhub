<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class MarkdownContent
 *
 * @property string $title
 * @property string $text
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class MarkdownContent
{
    public string $title;
    public string $text;

    public function __construct(string $title, string $text)
    {
        $this->title = $title;
        $this->text = $text;
    }
}
