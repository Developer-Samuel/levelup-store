<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Api\Feature\Product\Controller\Query;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Core\Ports\{
    Admin\Api\Product\Handler\Query\AdminApiProductListQueryHandlerContract,
    Security\Provider\SecurityProviderContract,
    Shared\Logging\AppLoggerContract
};

use App\Presentation\{
    Admin\Api\Abstract\AbstractAdminApiQueryController,
    Shared\Responder\ExceptionResponder
};

class AdminApiProductQueryController extends AbstractAdminApiQueryController
{
    /**
     * @param AdminApiProductListQueryHandlerContract $productListQueryHandler
     * @param SecurityProviderContract $securityProvider
     * @param ExceptionResponder $exceptionResponder
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly AdminApiProductListQueryHandlerContract $productListQueryHandler,
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
        $products = $this->productListQueryHandler->handle();

        return $this->respondWithList($products, 'products');
    }
}
