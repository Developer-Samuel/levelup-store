<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\Auth\Payload\SignupPayload;

use App\Core\Application\Abstract\Handler\AbstractRateLimitHandler;

use App\Core\Ports\{
    Auth\Handler\Command\SignupHandlerContract,
    Auth\Service\Command\LoginCommandContract,
    Auth\Service\Command\SignupCommandContract,
    Auth\Service\Command\VerificationCommandContract,
    Auth\Service\Query\LoginRedirectQueryContract,
    Auth\Trackers\SignupAttemptTrackerContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class SignupHandler extends AbstractRateLimitHandler implements SignupHandlerContract
{
    /**
     * @param SignupCommandContract $signupCommand
     * @param VerificationCommandContract $verificationCommand
     * @param LoginCommandContract $loginCommand
     * @param LoginRedirectQueryContract $loginRedirectQuery
     * @param SignupAttemptTrackerContract $tracker
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly SignupCommandContract $signupCommand,
        private readonly VerificationCommandContract $verificationCommand,
        private readonly LoginCommandContract $loginCommand,
        private readonly LoginRedirectQueryContract $loginRedirectQuery,
        private readonly SignupAttemptTrackerContract $tracker,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @param SignupPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handle(SignupPayload $payload): array
    {
        return $this->executeRateLimit($this->tracker, function() use ($payload) {
            $user = $this->signupCommand->signup($payload);

            $this->verificationCommand->createAndSaveTokenForUser($user);

            $tokenPair = $this->loginCommand->execute($user);

            return ApiResultFormatter::success(
                'User registered and verification email sent.',
                [
                    'access_token' => $tokenPair->accessToken,
                    'redirect'     => $this->loginRedirectQuery->getRedirectRoute($user),
                ],
            ) + ['refresh_token' => $tokenPair->refreshToken];
        });
    }
}
