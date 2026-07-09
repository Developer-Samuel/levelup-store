<?php

declare(strict_types=1);

namespace App\Core\Ports\Home\Service\Query;

interface HomeCacheQueryContract
{
    /**
     * @return array<string, mixed>
    */
    public function getHomeData(): array;
}
