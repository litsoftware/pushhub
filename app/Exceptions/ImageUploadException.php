<?php

namespace App\Exceptions;

use App\Exceptions\ExceptionInterface;
use Throwable;

class ImageUploadException extends \LogicException implements ExceptionInterface
{
    public function __construct($message = "文件上传失败", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
