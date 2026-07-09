<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\Auth\Payload\UpdateVerificationPayload;

use App\Core\Ports\{
    Auth\Service\Command\VerificationCommandContract,
    Auth\Handler\Command\UpdateVerificationHandlerContract,
    Shared\Logging\AppLoggerContract
};

final readonly class UpdateVerificationHandler implements UpdateVerificationHandlerContract
{
    /**
     * @param VerificationCommandContract $verificationCommand
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private VerificationCommandContract $verificationCommand,
        private AppLoggerContract $logger,
    ) {}

    /**
     * @param UpdateVerificationPayload $payload
     *
     * @return bool
    */
    public function handle(UpdateVerificationPayload $payload): bool
    {
        try {
            if ($payload->token === '') {
                return false;
            }

            return $this->verificationCommand->verifyUserByToken($payload);
        } catch (\Exception $exception) {
            $this->logger->error('Verification update failed', $exception, null, [
                'token' => $payload->token,
            ]);

            throw $exception;
        }
    }
}
