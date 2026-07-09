<?php

declare(strict_types=1);

namespace App\Core\Application\Admin\Segment\Product\Input\Variant\Ean;

use App\Core\Application\{
    Admin\Segment\Product\Constraint\Variant\EanConstraint,
    Segment\Product\Constraint\UniqueProductVariantEanCode,
    Shared\Constraint\NotBlankConstraint,
    Shared\Input\DecryptedId
};

trait AdminVariantEanUpdateInput
{
    use DecryptedId;

    #[NotBlankConstraint('ID')]
    public string $id;

    #[NotBlankConstraint('Variant ID')]
    public string $variantId;

    #[UniqueProductVariantEanCode]
    #[NotBlankConstraint('EAN Code')]
    #[EanConstraint(length: 13)]
    public string $code;
}
