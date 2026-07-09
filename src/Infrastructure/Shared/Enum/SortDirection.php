<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Enum;

enum SortDirection: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}
