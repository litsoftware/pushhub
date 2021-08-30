<?php

namespace App\Http\Controllers;


use App\Events\MsgSentEvent;
use App\Events\MsgSentFailEvent;
use App\Events\MsgSentSuccessEvent;
use App\Events\NewMessageEvent;
use App\Exceptions\InvalidArgumentException;
use App\Notifications\UniNotification;
use App\Notifier\Channel;
use App\Notifier\Dsn;
use App\Notifier\Recipient\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();

        try {
            if (!isset($params['channel']) && !$params['channel'] || !isset($params['data']))
                throw new InvalidArgumentException();

            $recipient = new Recipient(data_get($params, 'to'));

            $dsn = new Dsn($params['channel']);
            $channel = new Channel($dsn);
            $n = new UniNotification($channel);
            $n->setData($params);
            $n->from(data_get($params, 'from'));
            $n->content($params['data']);

            event(new NewMessageEvent($n));

            try {
                Notification::route('notifier', $recipient)->notify($n);
                event(new MsgSentSuccessEvent($n));
            } catch (\Throwable $e) {
                $n->setReason($e->getMessage());
                event(new MsgSentFailEvent($n));
                throw $e;
            }
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
}

