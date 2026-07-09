<?php

declare(strict_types=1);

namespace App\Presentation\Auth\Controller\Command;

use Symfony\{
    Component\HttpFoundation\Request,
    Component\HttpFoundation\JsonResponse,
    Component\HttpFoundation\Response,
    Component\Security\Csrf\CsrfTokenManagerInterface
};

use App\Core\Domain\Auth\Payload\UpdateVerificationPayload;

use App\Core\Ports\{
    Auth\Handler\Command\StoreVerificationHandlerContract,
    Auth\Handler\Command\UpdateVerificationHandlerContract,
    Auth\Trackers\VerificationAttemptTrackerContract,
    Shared\Logging\AppLoggerContract
};

use App\Presentation\{
    Abstract\Controller\Command\AbstractCrudCommandController,
    Auth\Request\VerificationRequest
};

class VerificationCommandController extends AbstractCrudCommandController
{
    /**
     * @param StoreVerificationHandlerContract $storeVerificationHandler
     * @param UpdateVerificationHandlerContract $updateVerificationHandler
     * @param VerificationAttemptTrackerContract $tracker
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly StoreVerificationHandlerContract $storeVerificationHandler,
        private readonly UpdateVerificationHandlerContract $updateVerificationHandler,
        private readonly VerificationAttemptTrackerContract $tracker,
        CsrfTokenManagerInterface $csrfTokenManager,
        AppLoggerContract $logger,
    ) {
        parent::__construct(
            $csrfTokenManager,
            $logger,
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
    */
    public function store(Request $request): JsonResponse
    {
        return $this->executeCommand(
            $request,
            VerificationRequest::class,
            fn () => $this->storeVerificationHandler->handle(),
            $this->tracker,
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
    */
    public function update(Request $request): Response
    {
        $payload = new UpdateVerificationPayload(
            token: $request->query->getString('token'),
        );

        $verified = $this->updateVerificationHandler->handle($payload);

        return $verified
            ? $this->redirectToRoute('home')
            : $this->redirectToRoute('must_verify');
    }
}
