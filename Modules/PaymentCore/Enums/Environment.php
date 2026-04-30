<?php

namespace Modules\PaymentCore\Enums;

enum Environment: string
{
    case TEST = "test";
    case LIVE = "live";
}
