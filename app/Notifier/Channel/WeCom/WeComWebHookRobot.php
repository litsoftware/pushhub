<?php


namespace App\Notifier\Channel\WeCom;


use App\Exceptions\InvalidArgumentException;
use App\Exceptions\InvalidConfigurationException;
use App\Exceptions\WeComChannelMediaUploadException;
use App\Notifier\Channel\WeCom\Messages\ArticleDetail;
use App\Notifier\Channel\WeCom\Messages\FileMessage;
use App\Notifier\Channel\WeCom\Messages\ImageMessage;
use App\Notifier\Channel\WeCom\Messages\MarkdownMessage;
use App\Notifier\Channel\WeCom\Messages\MessageInterface;
use App\Notifier\Channel\WeCom\Messages\NewsMessage;
use App\Notifier\Channel\WeCom\Messages\TextMessage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;

class WeComWebHookRobot
{
    private string $key;
    private Client $client;
    private string $uploadServiceUri = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/upload_media';
    private MessageInterface $msg;
    private $allTypes = [
        'text',
        'markdown',
        'news',
        'file',
        'image'
    ];

    public function __construct(string $webHookUri, string $key)
    {
        if (!$webHookUri || !$key) {
            throw new InvalidConfigurationException();
        }

        $client = new Client([
            'base_uri' => $webHookUri,
            'timeout'  => 2.0,
            'query' => ['key' => $key]
        ]);

        $this->client = $client;
        $this->key = $key;
    }

    /**
     * @param string $filePath
     * @return string
     */
    public function getFileMediaId(string $filePath): string
    {
        if (!$filePath)
            throw new InvalidArgumentException();

        $uploadClient = new Client([
            'base_uri' => $this->uploadServiceUri,
            'timeout'  => 2.0,
            'query' => [
                'key' => $this->key,
                'type' => 'file',
            ]
        ]);

        try {
            $response = $uploadClient->post('', [
                'multipart' => [
                    'name' => '',
                    'contents' => fopen(storage_path($filePath), 'r'),
                ]
            ]);
        } catch (GuzzleException $e) {
            throw new WeComChannelMediaUploadException();
        }

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        $mediaId = !empty($result['media_id']) ? $result['media_id'] : '';

        if (!$mediaId) {
            throw new WeComChannelMediaUploadException();
        }

        return $mediaId;
    }

    public function send(): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->post('', [
            'json' => $this->msg->toArray(),
        ]);
    }

    public function buildNewsMsg(array $articles): self
    {
        foreach ($articles as $article) {
            if (!($article instanceof ArticleDetail)) {
                throw new InvalidArgumentException();
            }
        }

        $this->msg = new NewsMessage();
        $this->msg->articles = $articles;
        return $this;
    }

    public function buildTextMsg(string $content, array $mentionedList, array $mentionedMobileList): self
    {
        $this->msg = new TextMessage();
        $this->msg->content = $content;
        $this->msg->mentionedList = $mentionedList;
        $this->msg->mentionedMobileList = $mentionedMobileList;
        return $this;
    }

    public function buildMarkdownMsg(string $content): self
    {
        $this->msg = new MarkdownMessage();
        $this->msg->content = $content;
        return $this;
    }

    public function buildImageMsg(string $imageData, string $hash): self
    {
        $this->msg = new ImageMessage();
        $this->msg->imageData = $imageData;
        $this->msg->hash = $hash;
        return $this;
    }

    public function buildImageMsgPath(string $imagePath, string $hash): self
    {
        $data = Storage::get($imagePath);
        return $this->buildImageMsg(base64_encode($data), $hash);
    }

    public function buildFileMsg(string $path): self
    {
        $this->msg = new FileMessage();
        $this->msg->mediaId = $this->getFileMediaId($path);

        return $this;
    }
}
