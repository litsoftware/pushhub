<?php


namespace App\Notifier\Channel\QcloudSms;

use App\Exceptions\ChannelUpstreamException;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\InvalidConfigurationException;
use App\Notifier\Recipient\Recipient;
use Qcloud\Sms\SmsSingleSender;
use Throwable;

class QcloudClient
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
     * @throws Throwable
     */
    public function send(Recipient $to, array $data)
    {
        $this->checkSign($data['sign']);
        $this->checkTmplId($data['tmpl_id']);

        try {
            $ssender = new SmsSingleSender($this->conf['app_id'], $this->conf['app_key']);
            $result = $ssender->sendWithParam(
                '',
                $to->getPhone(),
                $data['tmpl_id'],
                $data['params'],
                $data['sign'],
                "",
                "");

            $rsp = json_decode($result);
            if (property_exists($rsp, 'Error')) {
                throw new ChannelUpstreamException($rsp->Error->Message);
            }
        } catch(\Exception $e) {
           throw new ChannelUpstreamException($e->getMessage());
        }
    }
}
