<?php

namespace Modules\Merchant\Enums\Enum;

enum GrantType: string
{
    case PASSWORD = 'password';
    case REFRESH_TOKEN = 'refresh_token';
}
