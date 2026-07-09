<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Api\Feature\Banner\Controller\Query;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Core\Ports\{
    Admin\Api\Banner\Handler\Query\AdminApiBannerListQueryHandlerContract,
    Security\Provider\SecurityProviderContract,
    Shared\Logging\AppLoggerContract
};

use App\Presentation\{
    Admin\Api\Abstract\AbstractAdminApiQueryController,
    Shared\Responder\ExceptionResponder
};

class AdminApiBannerQueryController extends AbstractAdminApiQueryController
{
    /**
     * @param AdminApiBannerListQueryHandlerContract $bannerListQueryHandler
     * @param SecurityProviderContract $securityProvider
     * @param ExceptionResponder $exceptionResponder
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly AdminApiBannerListQueryHandlerContract $bannerListQueryHandler,
        SecurityProviderContract $securityProvider,
        ExceptionResponder $exceptionResponder,
        AppLoggerContract $logger,
    ) {
        parent::__construct(
            $securityProvider,
            $exceptionResponder,
            $logger,
        );
    }

    /**
     * @return JsonResponse
    */
    public function list(): JsonResponse
    {
        $banners = $this->bannerListQueryHandler->handle();

        return $this->respondWithList($banners, 'banners');
    }
}
