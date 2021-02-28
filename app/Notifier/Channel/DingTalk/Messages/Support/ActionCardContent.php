<?php


namespace App\Notifier\Channel\DingTalk\Messages\Support;

/**
 * Class ActionCardContent
 *
 * @property string $title
 * @property string $text
 * @property string $btnOrientation
 * @property string $singleTitle
 * @property string $singleURL
 *
 * @package App\Notifier\Channel\DingTalk\Messages\Support
 */
class ActionCardContent
{
    public string $title;
    public string $text;
    public string $btnOrientation;
    public string $singleTitle;
    public string $singleURL;

    public function __construct(string $title, string $text, string $singleTitle, string $singleURL, string $btnOrientation = '0')
    {
        $this->title = $title;
        $this->text = $text;
        $this->singleTitle = $singleTitle;
        $this->btnOrientation = $btnOrientation;
        $this->singleURL = $singleURL;
    }
}
