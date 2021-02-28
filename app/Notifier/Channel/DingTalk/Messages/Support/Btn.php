<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;


/**
 * Class Btn
 *
 * @property string $title
 * @property string $actionURL
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class Btn
{
    public string $title;
    public string $actionURL;

    public function __construct(string $title, string $actionURL)
    {
        $this->title = $title;
        $this->actionURL = $actionURL;
    }
}
