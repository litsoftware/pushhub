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

    public function publishToTopic()
    {

    }
}

