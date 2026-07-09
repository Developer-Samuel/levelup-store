<?php

declare(strict_types=1);

namespace App\Core\Domain\Admin\Segment\Product\Payload\Variant;

final readonly class AdminVariantEanPayload
{
    /**
     * @param string $code
     * @param string|null $variantId
     * @param string|null $id
    */
    public function __construct(
        public string $code,
        public ?string $variantId = null,
        public ?string $id = null,
    ) {}
}
