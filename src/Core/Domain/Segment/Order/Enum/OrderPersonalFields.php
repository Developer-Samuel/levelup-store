<?php

declare(strict_types=1);

namespace App\Core\Domain\Segment\Order\Enum;

enum OrderPersonalFields: string
{
    case EMAIL = 'email';
    case FIRST_NAME = 'first_name';
    case LAST_NAME = 'last_name';
}
