<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomRuntimeException extends Exception
{
    protected mixed $error;

    public function __construct(string $message = "Gateway request failed", int $code = 500, mixed $error = [])
    {
        $this->error = $error;
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return failureResponse($this->message, $this->error, $this->code);
    }
}
