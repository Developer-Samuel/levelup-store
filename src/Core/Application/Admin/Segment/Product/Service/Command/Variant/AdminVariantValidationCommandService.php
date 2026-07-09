<?php

declare(strict_types=1);

namespace App\Core\Application\Admin\Segment\Product\Service\Command\Variant;

use Kit\Utils\Shared\Sanitizer\DataSanitizer;

use App\Core\Ports\Admin\Segment\Product\Service\Command\Variant\AdminVariantValidationCommandContract;

class AdminVariantValidationCommandService implements AdminVariantValidationCommandContract
{
    /**
     * @param object $payload
     *
     * @return int
     *
     * @throws \RuntimeException
    */
    public function extractAndValidateId(object $payload, string $field = 'id'): int
    {
        $id = DataSanitizer::sanitizeInt($payload->$field ?? null);

        return $this->validatePositiveInt($id, 'ID');
    }

    /**
     * @param object $payload
     *
     * @return int
     *
     * @throws \RuntimeException
    */
    public function extractAndValidateVariantId(object $payload): int
    {
        $variantId = DataSanitizer::sanitizeInt($payload->variantId ?? null);

        return $this->validatePositiveInt($variantId, 'Variant ID');
    }

    /**
     * @param mixed $value
     * @param string $name
     *
     * @return int
     *
     * @throws \RuntimeException
    */
    private function validatePositiveInt(mixed $value, string $name): int
    {
        if (!is_int($value) || $value <= 0) {
            throw new \RuntimeException(sprintf('Invalid %s.', $name));
        }

        return $value;
    }
}
