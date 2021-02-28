<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class Link
 *
 * @property string $title
 * @property string $picUrl
 * @property string $messageUrl
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class Link
{
    public string $title;
    public string $picUrl;
    public string $messageUrl;

    public function __construct(string $title, string $picUrl, string $messageUrl)
    {
        $this->title = $title;
        $this->picUrl = $picUrl;
        $this->messageUrl = $messageUrl;
    }
}
