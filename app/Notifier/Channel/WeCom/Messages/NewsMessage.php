<?php


namespace App\Notifier\Channel\WeCom\Messages;


/**
 * Class NewsMessage
 *
 * @property array<ArticleDetail> $articles
 *
 * @package App\Notifier\Channel\WeCom\Messages
 */
final class NewsMessage extends AbstractMessage
{
    public function buildMessage()
    {
        $this->msg = [
            'msgtype' => 'news',
            'news' => [
                'articles' => $this->articles,
            ],
        ];
    }
}
