<?php

declare(strict_types=1);

namespace App\Core\Application\Segment\Review\Resource;

use App\Core\Domain\{
    Segment\Product\Entity\Variant\ProductVariant,
    Segment\Review\Entity\Review,
    Segment\Review\ValueObject\ReviewListObject
};

/**
 * @phpstan-import-type ResourceArray from ReviewListResource
*/
final class ReviewListWithVariantResource
{
    /**
     * @param ReviewListObject|null $list
     * @param ProductVariant $variant
     *
     * @return (ResourceArray & array{
     *     reviews: array<int, Review>,
     *     variant: ProductVariant
     * })|array{}
    */
    public static function toArray(?ReviewListObject $list, ProductVariant $variant): array
    {
        if ($list === null) {
            return [];
        }

        return [
            ...ReviewListResource::toArray($list) ?? [],
            'reviews' => array_values($list->reviews),
            'variant' => $variant,
        ];
    }
}
