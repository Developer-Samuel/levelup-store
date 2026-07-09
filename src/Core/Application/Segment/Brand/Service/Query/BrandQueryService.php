<?php

declare(strict_types=1);

namespace App\Core\Application\Segment\Brand\Service\Query;

use Kit\Assertion\Domain\Brand\BrandAssertion;

use App\Core\Domain\Segment\Brand\Entity\Brand;

use App\Core\Ports\{
    Segment\Brand\Service\Query\BrandQueryContract,
    Segment\Brand\Repository\BrandRepositoryContract
};

final readonly class BrandQueryService implements BrandQueryContract
{
    /**
     * @param BrandRepositoryContract $brandRepository
    */
    public function __construct(
        private BrandRepositoryContract $brandRepository,
    ) {}

    /**
     * @param int $id
     *
     * @return Brand
    */
    public function getBrandByIdOrFail(int $id): Brand
    {
        $brand = $this->brandRepository->findById($id);

        return BrandAssertion::assertExistsWithIdentifier(
            $brand,
            'Brand ID ' . $id,
        );
    }
}
