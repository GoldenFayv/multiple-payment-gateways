<?php

namespace Modules\Paystack\App\Services;

use Modules\PaymentCore\Enums\Enum\PaymentStatus;

class PaystackResponseMapper
{
    public function mapStatus(?string $status): PaymentStatus
    {
        return match ($status) {
            'success' => PaymentStatus::SUCCESSFUL,
            'failed' => PaymentStatus::FAILED,
            'abandoned' => PaymentStatus::CANCELLED,
            'reversed' => PaymentStatus::CANCELLED,
            'pending', 'processing', 'ongoing', 'queued' => PaymentStatus::PROCESSING,
            default => PaymentStatus::PENDING,
        };
    }
}
