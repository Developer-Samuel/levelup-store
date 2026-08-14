<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\{
    Auth\Payload\ResetPasswordPayload,
    Segment\Audit\Enum\AuditAction
};

use App\Core\Application\Abstract\Handler\AbstractCommandHandler;

use App\Core\Ports\{
    Auth\Handler\Command\ResetPasswordCommandHandlerContract,
    Auth\Service\Command\ResetPasswordCommandContract,
    Auth\Service\Query\ResetPasswordQueryContract,
    Segment\Audit\AuditLoggerContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class ResetPasswordCommandHandler extends AbstractCommandHandler implements ResetPasswordCommandHandlerContract
{
    /**
     * @param ResetPasswordQueryContract $resetPasswordQuery
     * @param ResetPasswordCommandContract $resetPasswordCommand
     * @param AuditLoggerContract $audit
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly ResetPasswordQueryContract $resetPasswordQuery,
        private readonly ResetPasswordCommandContract $resetPasswordCommand,
        private readonly AuditLoggerContract $audit,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @param ResetPasswordPayload $payload
     *
     * @return array<string, mixed>
     */
    public function handle(ResetPasswordPayload $payload): array
    {
        return $this->execute(function() use ($payload) {
            $user = $this->resetPasswordQuery->getValidUserWithToken($payload->token);

            $this->resetPasswordCommand->resetPassword($user, $payload->password);

            $this->audit->log(AuditAction::PASSWORD_RESET, 'User', $user->getId());

            return ApiResultFormatter::success('Password has been successfully reset.', [
                'redirect' => '/login',
            ]);
        });
    }
}
