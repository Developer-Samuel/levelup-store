<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\{
    Auth\Payload\LoginPayload,
    Segment\User\Entity\User
};

use App\Core\Application\Abstract\Handler\AbstractRateLimitHandler;

use App\Core\Ports\{
    Auth\Handler\Command\LoginHandlerContract,
    Auth\Service\Command\LoginCommandContract,
    Auth\Service\Query\LoginRedirectQueryContract,
    Auth\Trackers\LoginAttemptTrackerContract,
    Security\Provider\PasswordHasherProviderContract,
    Segment\User\Repository\UserRepositoryContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

final class LoginHandler extends AbstractRateLimitHandler implements LoginHandlerContract
{
    /**
     * @param UserRepositoryContract $userRepository
     * @param PasswordHasherProviderContract $passwordHasherProvider
     * @param LoginCommandContract $loginCommand
     * @param LoginAttemptTrackerContract $tracker
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly UserRepositoryContract $userRepository,
        private readonly PasswordHasherProviderContract $passwordHasherProvider,
        private readonly LoginCommandContract $loginCommand,
        private readonly LoginRedirectQueryContract $loginRedirectQuery,
        private readonly LoginAttemptTrackerContract $tracker,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @param LoginPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handle(LoginPayload $payload): array
    {
        return $this->executeRateLimit($this->tracker, function () use ($payload) {
            $user = $this->validateCredentials($payload);

            $tokenPair = $this->loginCommand->execute($user);

            return ApiResultFormatter::success(
                'Login successful',
                [
                    'access_token' => $tokenPair->accessToken,
                    'redirect'     => $this->loginRedirectQuery->getRedirectRoute($user),
                ],
            ) + ['refresh_token' => $tokenPair->refreshToken];
        });
    }

    /**
     * @param LoginPayload $payload
     *
     * @return User
     *
     * @throws \RuntimeException
    */
    private function validateCredentials(LoginPayload $payload): User
    {
        $user = $this->userRepository->findByEmail($payload->email);

        if ($user === null || !$this->passwordHasherProvider->isPasswordValid($user, $payload->password)) {
            throw new \RuntimeException('Invalid credentials.');
        }

        return $user;
    }
}
