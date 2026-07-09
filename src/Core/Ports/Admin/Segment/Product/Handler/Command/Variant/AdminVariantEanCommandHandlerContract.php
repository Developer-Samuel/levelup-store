<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Segment\Product\Handler\Command\Variant;

use App\Core\Domain\Admin\Segment\Product\Payload\Variant\AdminVariantEanPayload;

interface AdminVariantEanCommandHandlerContract
{
    /**
     * @param AdminVariantEanPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handleCreate(AdminVariantEanPayload $payload): array;

    /**
     * @param AdminVariantEanPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handleUpdate(AdminVariantEanPayload $payload): array;

    /**
     * @param int $eanId
     *
     * @return array<string, mixed>
    */
    public function handleDestroy(int $eanId): array;
}
