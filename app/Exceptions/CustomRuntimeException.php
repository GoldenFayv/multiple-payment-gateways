<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class CustomRuntimeException extends Exception
{
    public function __construct(string $message = "Gateway request failed", int $code = 500, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }

    public function render(): JsonResponse
    {
        return failureResponse($this->message, $this->getPrevious(), $this->code);
    }
}
