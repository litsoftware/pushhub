<?php


namespace App\Exceptions;


use Throwable;

class WeComChannelMediaUploadException extends \LogicException implements ExceptionInterface
{
    public function __construct($message = "微信文件上传错误", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
