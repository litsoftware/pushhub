<?php

namespace App\Http\Controllers;


use App\Notifications\SpecialityNotification;
use App\Notifier\Channel;
use App\Notifier\Dsn;
use App\Notifier\Recipient\Recipient;
use Illuminate\Support\Facades\Notification;

class WebhookController extends Controller
{
    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters);
    }

    public function index()
    {
        // dsn = 'type://channel@account'

        // dsn = 'sms://aliyun@default'
        // dsn = 'sms://aliyun@ssl100'
        // dsn = 'chat://wecom@cmzz'
        // dsn = 'chat://wechat_mp@default'


        $this->sendByChannel();
    }

    public function sendByChannel()
    {
        // 参数
        $params = [
            'dsn' => 'sms://default@aliyun',
            'to' => [
                'name' => '',
                'to' => '13632811904',
            ],
            'from' => [
                'name' => '',
                'address' => '',
            ],

            // 数据
            'data' => [
                // 普通文本内容，用于邮件（支持html）、境外短信
                'content' => '测试一下smtp的发送',

                // 富文本内容， 可用于 钉钉、企业微信、公众号的图文通知
                'rich_content' => [

                ],

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

        $recipient = new Recipient($params['to']);

        $dsn = new Dsn($params['dsn']);
        $channel = new Channel($dsn);
        $n = new SpecialityNotification($channel);
        $n->from($params['from']);
        $n->content($params['data']);

        Notification::route('notifier', $recipient)->notify($n);
    }

    public function publishToTopic()
    {

    }
}

