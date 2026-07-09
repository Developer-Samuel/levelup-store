<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Segment\Brand\Handler\Command;

use App\Core\Domain\Admin\Segment\Brand\Payload\AdminBrandPayload;

interface AdminBrandCommandHandlerContract
{
    /**
     * @param AdminBrandPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handleCreate(AdminBrandPayload $payload): array;

    /**
     * @param AdminBrandPayload $request
     *
     * @return array<string, mixed>
    */
    public function handleUpdate(AdminBrandPayload $request): array;

    /**
     * @param int $brandId
     *
     * @return array<string, mixed>
    */
    public function handleDestroy(int $brandId): array;
}
