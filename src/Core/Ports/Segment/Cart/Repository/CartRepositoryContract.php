<?php

declare(strict_types=1);

namespace App\Core\Ports\Segment\Cart\Repository;

use App\Core\Domain\Segment\Cart\Entity\Cart;

interface CartRepositoryContract
{
    /**
     * @param int $userId
     *
     * @return Cart|null
    */
    public function findCartForUser(int $userId): ?Cart;
}
