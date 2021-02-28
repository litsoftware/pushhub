<?php


namespace App\Notifier\Channel\WeCom;


use App\Exceptions\InvalidArgumentException;
use App\Models\Media;
use App\Notifications\UniNotification;
use App\Notifier\Channel\WeCom\Messages\ArticleDetail;
use App\Notifier\Channel\WeCom\Messages\Types;
use Illuminate\Support\Facades\Storage;


class WeComChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     */
    public function send($notifiable, UniNotification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('notifier')) {
            return;
        }

        $config = $notification->getChannelConfiguration();
        $content = $notification->toWeCom();

        $msgType = $content['msgtype'];
        Types::check($msgType);

        $client = new WeComWebHookRobot($config['webhook'], $config['key']);

        switch ($msgType) {
            case Types::TEXT:
                $client->buildTextMsg($content['text']['content'], data_get($content, 'text.mentioned_list', []), data_get($content, 'text.mentioned_mobile_list', []));
                break;

            case Types::MARKDOWN:
                $client->buildMarkdownMsg($content['markdown']['content']);
                break;

            case Types::IMAGE:
                $client->buildImageMsg($content['image']['base64'], $content['image']['md5']);
                break;

            case Types::NEWS:
                $articles = [];
                if (count($content['news']['articles'])) {
                    foreach ($content['news']['articles'] as $item) {
                        $article = new ArticleDetail();
                        $article->title = $item['title'];
                        $article->description = data_get($item, 'description', '');
                        $article->url = $item['url'];
                        $article->picurl = data_get($item, 'picurl', '');

                        array_push($articles, $article);
                    }
                } else {
                    throw new InvalidArgumentException();
                }

                $client->buildNewsMsg($articles);
                break;

            case Types::FILE:
                $mediaId = $content['file']['media_id'];
                $media = Media::where(Media::MEDIA_ID, $mediaId)->firstOrFail();

                $path = $media->{Media::PATH};
                if ($media->{Media::FS_DRIVER} != 'local') {
                    $orgPath = $path;
                    $path = storage_path($path);
                    Storage::copy($orgPath, $path);
                }

                $client->buildFileMsg($path);
                break;


            default:
                throw new InvalidArgumentException();
        }

        $client->send();
    }
}
