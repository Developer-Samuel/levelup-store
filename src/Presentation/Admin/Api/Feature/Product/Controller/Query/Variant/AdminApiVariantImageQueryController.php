<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Api\Feature\Product\Controller\Query\Variant;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Core\Ports\{
    Admin\Api\Product\Handler\Query\Variant\AdminApiVariantImageListQueryHandlerContract,
    Security\Provider\SecurityProviderContract,
    Shared\Logging\AppLoggerContract
};

use App\Presentation\{
    Admin\Api\Abstract\AbstractAdminApiQueryController,
    Shared\Responder\ExceptionResponder
};

class AdminApiVariantImageQueryController extends AbstractAdminApiQueryController
{
    /**
     * @param AdminApiVariantImageListQueryHandlerContract $imageListQueryHandler
     * @param SecurityProviderContract $securityProvider
     * @param ExceptionResponder $exceptionResponder
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly AdminApiVariantImageListQueryHandlerContract $imageListQueryHandler,
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
     * @param int $id
     *
     * @return JsonResponse
    */
    public function list(int $id): JsonResponse
    {
        $images = $this->imageListQueryHandler->handle(['variantId' => $id]);

        return $this->respondWithList($images, 'images');
    }
}
