<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Api\Product\Handler\Query\Variant;

interface AdminApiVariantListQueryHandlerContract
{
    /**
     * @param int $productId
     *
     * @return array<int, array<string, mixed>>
     */
    public function handle(int $productId): array;
}
