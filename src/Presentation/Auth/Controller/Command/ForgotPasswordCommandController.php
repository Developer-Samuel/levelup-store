<?php

declare(strict_types=1);

namespace App\Presentation\Auth\Controller\Command;

use Symfony\{
    Component\HttpFoundation\JsonResponse,
    Component\HttpFoundation\Request,
    Component\Security\Csrf\CsrfTokenManagerInterface,
    Component\Validator\Validator\ValidatorInterface
};

use App\Core\Domain\Auth\Payload\ForgotPasswordPayload;

use App\Core\Ports\{
    Auth\Handler\Command\ForgotPasswordCommandHandlerContract,
    Shared\Logging\AppLoggerContract
};

use App\Presentation\{
    Abstract\Controller\Command\AbstractCrudCommandController,
    Auth\Request\ForgotPasswordRequest
};

class ForgotPasswordCommandController extends AbstractCrudCommandController
{
    /**
     * @param ForgotPasswordCommandHandlerContract $forgotPasswordCommandHandler
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param AppLoggerContract $logger
     * @param ValidatorInterface $validator
    */
    public function __construct(
        private readonly ForgotPasswordCommandHandlerContract $forgotPasswordCommandHandler,
        CsrfTokenManagerInterface $csrfTokenManager,
        AppLoggerContract $logger,
        ValidatorInterface $validator,
    ) {
        parent::__construct(
            $csrfTokenManager,
            $logger,
            $validator,
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
            ForgotPasswordRequest::class,
            fn(ForgotPasswordRequest $forgotPasswordRequest): array => $this->handleStore($forgotPasswordRequest),
        );
    }

    /**
     * @param ForgotPasswordRequest $request
     *
     * @return array<string, mixed>
    */
    private function handleStore(ForgotPasswordRequest $request): array
    {
        $payload = new ForgotPasswordPayload(
            email: $request->email,
        );

        return $this->forgotPasswordCommandHandler->handle($payload);
    }
}
