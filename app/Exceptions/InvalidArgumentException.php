<?php


namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    #[Pure] public function __construct($message = "参数错误", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
