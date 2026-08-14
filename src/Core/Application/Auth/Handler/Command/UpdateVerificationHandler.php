<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\{
    Auth\Payload\UpdateVerificationPayload,
    Segment\Audit\Enum\AuditAction
};

use App\Core\Ports\{
    Auth\Handler\Command\UpdateVerificationHandlerContract,
    Auth\Service\Command\VerificationCommandContract,
    Segment\Audit\AuditLoggerContract,
    Shared\Logging\AppLoggerContract
};

final readonly class UpdateVerificationHandler implements UpdateVerificationHandlerContract
{
    /**
     * @param VerificationCommandContract $verificationCommand
     * @param AuditLoggerContract $audit
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private VerificationCommandContract $verificationCommand,
        private AuditLoggerContract $audit,
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

            $user = $this->verificationCommand->verifyUserByToken($payload);

            if ($user !== null) {
                $this->audit->log(AuditAction::EMAIL_VERIFIED, 'User', $user->getId(), [], $user);
            }

            return $user !== null;
        } catch (\Exception $exception) {
            $this->logger->error('Verification update failed', $exception, null, [
                'token' => $payload->token,
            ]);

            throw $exception;
        }
    }
}
