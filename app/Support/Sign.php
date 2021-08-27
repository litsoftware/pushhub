<?php
declare(strict_types=1);

namespace App\Support;

use App\Models\App;
use App\Models\AppDevParam;
use App\Exceptions\SignErrorException;
use App\Keys;

class Sign
{
    public static function generatePaymentSign($data, $key)
    {
        ksort($data);
        $sign = strtoupper(md5(urldecode(http_build_query($data)).'&key='.$key));
        return $sign;
    }

    public static function generate($data): string
    {
        $id = data_get($data, 'mch_id');
        $signData = [];

        foreach ($data as $k => $v) {
            if ($v !== null && trim((string)$v) !== '' && $k !== 'sign') {
                $signData[$k] = $v;
            }
        }

        if (!$app = session(Keys::SES_APP)) {
            $app = App::where(App::APP_ID, $id)->first();
        }

        $key = $app->devParam->{AppDevParam::API_KEY};

        ksort($signData);
        $tmpStr = urldecode(http_build_query($signData)).'&key='.$key;

        $sign = strtoupper(md5($tmpStr));

        return $sign;
    }

    public static function verify($data, $sign = null): bool
    {
        if (!$sign) {
            if (!isset($data['sign'])) {
                throw new SignErrorException();
            }

            $sign = data_get($data, 'sign');
            unset($data['sign']);
        }

        if (!$sign) {
            throw new SignErrorException();
        }

        $tSign = static::generate($data);
        if ($sign !== $tSign) {
            throw new SignErrorException();
        }

        return true;
    }
}
