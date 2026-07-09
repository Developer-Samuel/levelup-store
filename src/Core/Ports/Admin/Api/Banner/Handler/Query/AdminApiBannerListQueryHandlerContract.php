<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Api\Banner\Handler\Query;

interface AdminApiBannerListQueryHandlerContract
{
    /**
     * @param array{
     *     page?: int,
     *     limit?: int,
     *     search?: string,
     *     role?: string,
     *     isActive?: bool,
     *     sort?: 'asc'|'desc'
     * } $context
     *
     * @return array<int, array<string, mixed>>
    */
    public function handle(array $context = []): array;
}
