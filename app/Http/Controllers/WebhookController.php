<?php

namespace App\Http\Controllers;


use App\Exceptions\InvalidArgumentException;
use App\Notifications\UniNotification;
use App\Notifier\Channel;
use App\Notifier\Dsn;
use App\Notifier\Recipient\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class WebhookController extends Controller
{
    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters);
    }

    public function index(Request $request)
    {
        $params = $request->all();

        try {
            if (!isset($params['dsn']) && !$params['dsn'] || !isset($params['data']))
                throw new InvalidArgumentException();

            $recipient = new Recipient(data_get($params, 'to'));

            $dsn = new Dsn($params['dsn']);
            $channel = new Channel($dsn);
            $n = new UniNotification($channel);
            $n->from(data_get($params, 'from'));
            $n->content($params['data']);

            Notification::route('notifier', $recipient)->notify($n);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'notification_id' => $n->getId()
        ]);
    }

    private function dingTalk()
    {
        // 参数
        $params = [
            'dsn' => 'chat://default@dingtalk',

            // 数据
            'data' => [
                'content' => [
                    'msgtype' => 'text',
                    'text' => [
                        'content' => '我就是我, 是不一样的烟火'
                    ]
                ],
            ],
        ];

        $recipient = new Recipient(data_get($params, 'to'));

        $dsn = new Dsn($params['dsn']);
        $channel = new Channel($dsn);
        $n = new UniNotification($channel);
        $n->from(data_get($params, 'from'));
        $n->content($params['data']);

        Notification::route('notifier', $recipient)->notify($n);
    }

    private function wecom()
    {
        // 参数
        $params = [
            'dsn' => 'chat://cmzz_test@wecom',

            // 数据
            'data' => [
                'content' => [
                    'msgtype' => 'text',
                    'text' => [
                        'content' => '此时固定为text'
                    ]
                ],
            ],
        ];

        $recipient = new Recipient(data_get($params, 'to'));

        $dsn = new Dsn($params['dsn']);
        $channel = new Channel($dsn);
        $n = new UniNotification($channel);
        $n->from(data_get($params, 'from'));
        $n->content($params['data']);

        Notification::route('notifier', $recipient)->notify($n);
    }

    private function sms()
    {
        // 参数
        $params = [
            'dsn' => 'sms://default@aliyun',

            // 接收目标， 适用于 email/sms
            'to' => [
                'name' => '',
                'to' => '13632811904',
            ],

            // 发送人 适用于 email
            'from' => [
                'name' => '',
                'address' => '',
            ],

            // 数据
            'data' => [
                // 普通文本内容(string)，用于邮件（支持html）、境外短信
                // 富文本内容(array)，可用于 钉钉、企业微信、公众号的图文通知
                'content' => '测试一下smtp的发送',

                // 模板id 用于国内 sms / email
                'tmpl_id' => 'SMS_126355301',

                // 模板参数 用于国内 sms / email
                'params' => [
                    'code' => 1234,
                ],

                // 签名 用于国内sms
                'sign' => '创梦空间',

                // 附件 用于邮件
                'attachment' => [

                ],
            ],
        ];

        $recipient = new Recipient(data_get($params, 'to'));

        $dsn = new Dsn($params['dsn']);
        $channel = new Channel($dsn);
        $n = new UniNotification($channel);
        $n->from(data_get($params, 'from'));
        $n->content($params['data']);

        Notification::route('notifier', $recipient)->notify($n);
    }

    public function publishToTopic()
    {

    }
}

