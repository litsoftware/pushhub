<?php

namespace App\Notifier\Channel\AliyunSms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Exceptions\WeComChannelMediaUploadException;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\InvalidConfigurationException;
use App\Notifier\Recipient\Recipient;
use Throwable;

class AliyunSmsClient
{
    private array $conf;

    public function __construct(array $conf)
    {
        $this->conf = $conf;
    }

    /**
     * @param string $tmplId
     * @throws Throwable
     */
    public function checkTmplId(string $tmplId)
    {
        throw_if(!$this->conf['tmpl'], InvalidConfigurationException::class);
        throw_if(!$tmplId, InvalidArgumentException::class);
        throw_if(!collect($this->conf['tmpl'])->contains('id', $tmplId), InvalidArgumentException::class);
    }

    /**
     * @param string $sign
     * @throws Throwable
     */
    public function checkSign(string $sign)
    {
        throw_if(!$this->conf['sign'], InvalidConfigurationException::class);
        throw_if(!collect($this->conf['sign'])->contains($sign), InvalidArgumentException::class);
    }

    /**
     * @param Recipient $to
     * @param array $data
     * @throws ClientException|Throwable
     */
    public function send(Recipient $to, array $data)
    {
        $this->checkSign($data['sign']);
        $this->checkTmplId($data['tmpl_id']);

        AlibabaCloud::accessKeyClient($this->conf['ak'], $this->conf['sk'])
            ->regionId($this->conf['region'])
            ->asDefaultClient();

        $query = [
            'RegionId' => $this->conf['region'],
            'PhoneNumbers' => $to->getPhone(),
            'SignName' => $data['sign'],
            'TemplateCode' => $data['tmpl_id'],
        ];

        if (isset($data['params']) && $data['params']) {
            $query['TemplateParam'] = json_encode($data['params']);
        }

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->scheme('https')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => $query,
                ])
                ->request();
            if ($result->toArray()['Code'] != "OK") {
                throw new WeComChannelMediaUploadException($result->toArray()['Message']);
            }
        } catch (ClientException | ServerException $e) {
            throw new WeComChannelMediaUploadException($e->getErrorMessage());
        }
    }
}
