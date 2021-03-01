<?php


namespace App\Exceptions;


use Throwable;

class NotSupportChannelException extends \LogicException implements ExceptionInterface
{
    public function __construct($message = "不支持的通道", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
