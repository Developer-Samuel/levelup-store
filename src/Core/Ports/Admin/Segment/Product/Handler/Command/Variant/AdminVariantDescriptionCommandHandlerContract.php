<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Segment\Product\Handler\Command\Variant;

use App\Core\Domain\Admin\Segment\Product\Payload\Variant\AdminVariantDescriptionPayload;

interface AdminVariantDescriptionCommandHandlerContract
{
    /**
     * @param AdminVariantDescriptionPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handleCreate(AdminVariantDescriptionPayload $payload): array;

    /**
     * @param AdminVariantDescriptionPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handleUpdate(AdminVariantDescriptionPayload $payload): array;

    /**
     * @param int $descriptionId
     *
     * @return array<string, mixed>
    */
    public function handleDestroy(int $descriptionId): array;
}
