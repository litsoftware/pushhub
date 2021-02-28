<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class LinkContent
 *
 * @property string $text
 * @property string $title
 * @property string $picUrl
 * @property string $messageUrl
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class LinkContent
{
    public string $text;
    public string $title;
    public string $picUrl;
    public string $messageUrl;

    public function __construct(string $title, string $text, string $messageUrl, string $picUrl = '')
    {
        $this->title = $title;
        $this->text = $text;
        $this->messageUrl = $messageUrl;
        $this->$picUrl = $picUrl;
    }
}
