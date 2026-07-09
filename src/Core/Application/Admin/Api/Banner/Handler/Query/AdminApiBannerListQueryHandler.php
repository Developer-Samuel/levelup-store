<?php

declare(strict_types=1);

namespace App\Core\Application\Admin\Api\Banner\Handler\Query;

use App\Core\Domain\Segment\Banner\Entity\Banner;

use App\Core\Application\{
    Admin\Abstract\Handler\AbstractAdminApiListQueryHandler,
    Admin\Api\Banner\Resource\AdminApiBannerResource
};

use App\Core\Ports\{
    Admin\Api\Banner\Handler\Query\AdminApiBannerListQueryHandlerContract,
    Segment\Banner\Repository\BannerRepositoryContract,
    Shared\Logging\AppLoggerContract
};

class AdminApiBannerListQueryHandler extends AbstractAdminApiListQueryHandler implements AdminApiBannerListQueryHandlerContract
{
    /**
     * @param BannerRepositoryContract $bannerRepository
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly BannerRepositoryContract $bannerRepository,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @return Banner[]
    */
    protected function getRepositoryClass(array $context = []): array
    {
        return $this->bannerRepository->findAll();
    }

    /**
     * @return string
    */
    protected function getResourceClass(): string
    {
        return AdminApiBannerResource::class;
    }
}
