<?php


namespace App\Exceptions;


use Throwable;

class InvalidConfigurationException extends \InvalidArgumentException implements ExceptionInterface
{
    public function __construct($message = "配置错误", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
