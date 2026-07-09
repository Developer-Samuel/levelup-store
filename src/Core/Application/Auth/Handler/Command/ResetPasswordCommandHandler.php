<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\{
    Auth\Payload\ResetPasswordPayload,
    Segment\User\Entity\User
};

use App\Core\Application\Abstract\Handler\AbstractRateLimitHandler;

use App\Core\Ports\{
    Auth\Handler\Command\ResetPasswordCommandHandlerContract,
    Auth\Service\Command\ResetPasswordCommandContract,
    Auth\Service\Query\ResetPasswordQueryContract,
    Auth\Trackers\ResetPasswordAttemptTrackerContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class ResetPasswordCommandHandler extends AbstractRateLimitHandler implements ResetPasswordCommandHandlerContract
{
    /**
     * @param ResetPasswordQueryContract $resetPasswordQuery
     * @param ResetPasswordCommandContract $resetPasswordCommand
     * @param ResetPasswordAttemptTrackerContract $tracker
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly ResetPasswordQueryContract $resetPasswordQuery,
        private readonly ResetPasswordCommandContract $resetPasswordCommand,
        private readonly ResetPasswordAttemptTrackerContract $tracker,
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
        return $this->executeRateLimit($this->tracker, function() use ($payload) {
            $user = $this->resetPasswordQuery->getValidUserWithToken($payload->token);

            return $this->performPasswordReset($user, $payload->password);
        });
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @return array<string, mixed>
    */
    private function performPasswordReset(User $user, string $password): array
    {
        $this->resetPasswordCommand->resetPassword($user, $password);

        return ApiResultFormatter::success('Password has been successfully reset.', [
            'redirect' => '/login',
        ]);
    }
}
