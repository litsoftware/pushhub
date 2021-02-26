<?php


namespace App\Notifier\Channel\AliyunSms;


use App\Notifications\SpecialityNotification;
use Illuminate\Support\Facades\Notification;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class AliyunSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param mixed $notification
     * @throws ClientException
     */
    public function send($notifiable, SpecialityNotification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('notifier')) {
            return;
        }

        $config = $notification->getChannelConfiguration();

        AlibabaCloud::accessKeyClient($config['ak'], $config['sk'])
            ->regionId($config['region'])
            ->asDefaultClient();

        $data = $notification->toTmplSms();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->scheme('https')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => $config['region'],
                        'PhoneNumbers' => $to->getPhone(),
                        'SignName' => $data['sign'],
                        'TemplateCode' => $data['tmpl_id'],
                        'TemplateParam' => json_encode($data['params']),
                    ],
                ])
                ->request();

            dump($result->toArray());
        } catch (ClientException | ServerException $e) {
            dump($e->getErrorMessage());
        }
    }
}
