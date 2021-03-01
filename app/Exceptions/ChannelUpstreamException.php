<?php


namespace App\Exceptions;


use Throwable;

class ChannelUpstreamException extends \LogicException implements ExceptionInterface
{
    public function __construct($message = "上游消息通道错误", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
