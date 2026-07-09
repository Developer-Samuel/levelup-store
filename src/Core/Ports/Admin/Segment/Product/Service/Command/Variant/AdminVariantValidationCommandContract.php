<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Segment\Product\Service\Command\Variant;

interface AdminVariantValidationCommandContract
{
    /**
     * @param object $payload
     *
     * @return int
     *
     * @throws \RuntimeException
    */
    public function extractAndValidateId(object $payload, string $field = 'id'): int;

    /**
     * @param object $payload
     *
     * @return int
     *
     * @throws \RuntimeException
    */
    public function extractAndValidateVariantId(object $payload): int;
}
