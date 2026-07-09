<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Api\Feature\Brand\Controller\Query;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Core\Ports\{
    Admin\Api\Brand\Handler\Query\AdminApiBrandListQueryHandlerContract,
    Security\Provider\SecurityProviderContract,
    Shared\Logging\AppLoggerContract
};

use App\Presentation\{
    Admin\Api\Abstract\AbstractAdminApiQueryController,
    Shared\Responder\ExceptionResponder
};

class AdminApiBrandQueryController extends AbstractAdminApiQueryController
{
    /**
     * @param AdminApiBrandListQueryHandlerContract $brandListQueryHandler
     * @param SecurityProviderContract $securityProvider
     * @param ExceptionResponder $exceptionResponder
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly AdminApiBrandListQueryHandlerContract $brandListQueryHandler,
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
        $brands = $this->brandListQueryHandler->handle();

        return $this->respondWithList($brands, 'brands');
    }
}
