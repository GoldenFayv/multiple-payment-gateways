<?php

namespace App\Enums;

enum CacheKey: string
{
    case EMAIL_VERIFY = 'email.verify';

    public function dynamicKey(string $model, mixed $input): string
    {
        return "{$model}.{$this->value}.{$input}";
    }
}
