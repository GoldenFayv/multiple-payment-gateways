<?php

namespace Modules\PaymentCore\Enums\Enum;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SUCCESSFUL = 'successful';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
}
