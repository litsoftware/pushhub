<?php


namespace App\Notifier\Channel\DingTalk;


use App\Exceptions\InvalidArgumentException;
use App\Notifications\UniNotification;
use App\Notifier\Channel\DingTalk\Messages\Types;


class DingTalkChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     */
    public function send($notifiable, UniNotification $notification)
    {
        $content = $notification->toDingTalk();
        $config = $notification->getChannelConfiguration();

        $msgType = $content['msgtype'];
        Types::check($msgType);

        $client = new DingTalkWebHookRobot($config['token'], $config['secret'], $config['sign']);
        switch ($msgType) {
            case Types::TEXT:
                $client->buildTextMsg(
                    $content['text']['content'],
                    data_get($content, 'at.isAtAll', false),
                    data_get($content, 'at.atMobiles', [])
                );
                break;

            case Types::LINK:
                $client->buildLinkMsg(
                    $content['link']['title'],
                    $content['link']['text'],
                    $content['link']['messageUrl'],
                    data_get($content, 'link.picUrl')
                );
                break;

            case Types::MARKDOWN:
                $client->buildMarkdownMsg(
                    $content['markdown']['title'],
                    $content['markdown']['text'],
                    data_get($content, 'at.isAtAll', false),
                    data_get($content, 'at.atMobiles', [])
                );
                break;

            case Types::ACTION_CARD:
                if (isset($content['actionCard']['singleURL'])) {
                    $client->buildActionCardMsg(
                        $content['actionCard']['title'],
                        $content['actionCard']['text'],
                        $content['actionCard']['singleTitle'],
                        $content['actionCard']['singleURL'],
                        data_get($content, 'actionCard.btnOrientation'),
                    );
                } else {
                    $client->buildSingleActionCardMsg(
                        $content['actionCard']['title'],
                        $content['actionCard']['text'],
                        data_get($content, 'actionCard.hideAvatar', '0'),
                        data_get($content, 'actionCard.btns', []),
                        data_get($content, 'actionCard.btnOrientation', '0'),
                    );
                }
                break;

            case Types::FEED_CARD:
                $client->buildFeedCardMsg(
                    $content['feedCard']['links']
                );
                break;

            default:
                throw new InvalidArgumentException();
        }

        $client->send();
    }
}
