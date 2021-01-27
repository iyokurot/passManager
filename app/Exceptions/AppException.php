<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    public $request;
    public $message;
    public $code;


    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code   = $code;
    }
}
