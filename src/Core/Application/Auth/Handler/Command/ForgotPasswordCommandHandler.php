<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\Auth\Payload\ForgotPasswordPayload;

use App\Core\Application\Abstract\Handler\AbstractRateLimitHandler;

use App\Core\Ports\{
    Auth\Handler\Command\ForgotPasswordCommandHandlerContract,
    Auth\Service\Command\ForgotPasswordCommandContract,
    Auth\Trackers\ForgotPasswordAttemptTrackerContract,
    Segment\User\Service\Query\UserQueryContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class ForgotPasswordCommandHandler extends AbstractRateLimitHandler implements ForgotPasswordCommandHandlerContract
{
    /**
     * @param ForgotPasswordCommandContract $forgotPasswordCommand
     * @param ForgotPasswordAttemptTrackerContract $tracker
     * @param UserQueryContract $userQuery
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly ForgotPasswordCommandContract $forgotPasswordCommand,
        private readonly ForgotPasswordAttemptTrackerContract $tracker,
        private readonly UserQueryContract $userQuery,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @param ForgotPasswordPayload $payload
     *
     * @return array<string, mixed>
     */
    public function handle(ForgotPasswordPayload $payload): array
    {
        return $this->executeRateLimit($this->tracker, function() use ($payload) {
            $user = $this->userQuery->findUserByEmailOrFail($payload->email);

            $this->forgotPasswordCommand->createAndSaveTokenForUser($user);

            return ApiResultFormatter::success('We have sent you an email with a link to change your password.');
        });
    }
}
