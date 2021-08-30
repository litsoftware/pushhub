<?php


namespace App\Notifier\Channel\DingTalk;


use App\Exceptions\ChannelUpstreamException;
use App\Exceptions\InvalidConfigurationException;
use App\Notifier\Channel\DingTalk\Messages\ActionCardMessage;
use App\Notifier\Channel\DingTalk\Messages\FeedCardMessage;
use App\Notifier\Channel\DingTalk\Messages\LinkMessage;
use App\Notifier\Channel\DingTalk\Messages\MarkdownMessage;
use App\Notifier\Channel\DingTalk\Messages\MessageInterface;
use App\Notifier\Channel\DingTalk\Messages\SingleActionCardMessage;
use App\Notifier\Channel\DingTalk\Messages\Support\ActionCardContent;
use App\Notifier\Channel\DingTalk\Messages\Support\At;
use App\Notifier\Channel\DingTalk\Messages\Support\Btn;
use App\Notifier\Channel\DingTalk\Messages\Support\FeedCardContent;
use App\Notifier\Channel\DingTalk\Messages\Support\Link;
use App\Notifier\Channel\DingTalk\Messages\Support\LinkContent;
use App\Notifier\Channel\DingTalk\Messages\Support\MarkdownContent;
use App\Notifier\Channel\DingTalk\Messages\Support\SingleActionCardContent;
use App\Notifier\Channel\DingTalk\Messages\Support\TextContent;
use App\Notifier\Channel\DingTalk\Messages\TextMessage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DingTalkWebHookRobot
{
    const WEB_HOOK_URL = 'https://oapi.dingtalk.com/robot/send';

    protected string $token = '';
    protected string $secret = '';
    protected bool $sign = false;
    private Client $client;
    private MessageInterface $msg;

    private float $mSecond;

    public function __construct(string $token, string $secret, bool $sign = false)
    {
        if (!$token || !$secret) {
            throw new InvalidConfigurationException();
        }

        $this->token = $token;
        $this->secret = $secret;
        $this->sign = $sign;

        $this->millisecond();

        $this->client = new Client([
            'base_uri' => self::WEB_HOOK_URL,
            'timeout'  => 2.0,
        ]);
    }

    private function sign(): string
    {
        $signString = $this->mSecond . "\n" . $this->secret;
        $hash = hash_hmac('sha256', $signString, $this->secret, true);

        return base64_encode($hash);
    }

    private function millisecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        $this->mSecond = (float) sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

    public function send()
    {
        $query = [
            'access_token' => $this->token,
            'timestamp' => $this->mSecond,
            'sign' => $this->sign(),
        ];

        try {
            $response = $this->client->post('', [
                'query' => $query,
                'headers' => [
                    'Content-Type' => 'application/json;charset=utf-8'
                ],
                'json' => (array)$this->msg
            ]);
        } catch (GuzzleException $e) {
            throw new ChannelUpstreamException($e->getMessage());
        }

        if ($response->getStatusCode() != 200) {
            throw new ChannelUpstreamException();
        }

        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);

        if (isset($result['errcode']) && $result['errcode'] != 0) {
            throw new ChannelUpstreamException(sprintf('%s:%s', $result['errcode'], $result['errmsg']));
        }
    }

    function buildTextMsg(string $content, bool $isAtAll = false, array $atMobiles = []): self
    {
        $this->msg = new TextMessage(new TextContent($content), new At($isAtAll, $atMobiles));

        return $this;
    }

    function buildLinkMsg(string $title, string $text, string $messageUrl, string $picUrl = ''): self
    {
        $this->msg = new LinkMessage(new LinkContent($title, $text, $messageUrl, $picUrl));

        return $this;
    }

    function buildMarkdownMsg(string $title, string $text, bool $isAtAll = false, array $atMobiles = []): self
    {
        $this->msg = new MarkdownMessage(new MarkdownContent($title, $text), new At());

        return $this;
    }

    function buildActionCardMsg(string $title, string $text, string $singleTitle, string $singleURL, string $btnOrientation = '0'): self
    {
        $t = new ActionCardContent($title, $text, $singleTitle, $singleURL, $btnOrientation);
        $this->msg = new ActionCardMessage($t);

        return $this;
    }

    function buildSingleActionCardMsg(string $title, string $text, string $hideAvatar, array $btns, string $btnOrientation = '0'): self
    {
        $btnList = [];
        if (count($btns)) {
            foreach ($btns as $btn) {
                array_push($btnList, new Btn(data_get($btn, 'title'), data_get($btn, 'actionURL')));
            }
        }

        $this->msg = new SingleActionCardMessage(new SingleActionCardContent($title, $text, $hideAvatar, $btnList, $btnOrientation));

        return $this;
    }

    function buildFeedCardMsg(array $links): self
    {
        $linkList = [];
        if (count($links)) {
            foreach ($links as $link) {
                array_push($linkList, new Link(
                    data_get($link, 'title'),
                    data_get($link, 'picURL'),
                    data_get($link, 'messageURL')
                ));
            }
        }
        $this->msg = new FeedCardMessage(new FeedCardContent($linkList));

        return $this;
    }
}
