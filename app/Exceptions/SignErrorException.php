<?php
declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class SignErrorException extends HttpException
{
    public function __construct(
        $message = '签名错误',
        $code = 50001,
        $statusCode = Response::HTTP_BAD_REQUEST,
        \Exception $previous = null,
        array $headers = array()
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
