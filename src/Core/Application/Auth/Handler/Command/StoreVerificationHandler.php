<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Handler\Command;

use App\Core\Domain\Segment\User\Entity\User;

use App\Core\Domain\Exception\ConflictException;

use App\Core\Application\Abstract\Handler\AbstractRateLimitHandler;

use App\Core\Ports\{
    Auth\Handler\Command\StoreVerificationHandlerContract,
    Auth\Service\Command\VerificationCommandContract,
    Auth\Trackers\VerificationAttemptTrackerContract,
    Security\Policy\SecurityPolicyContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class StoreVerificationHandler extends AbstractRateLimitHandler implements StoreVerificationHandlerContract
{
    /**
     * @param SecurityPolicyContract $securityPolicy
     * @param VerificationCommandContract $verificationCommand
     * @param VerificationAttemptTrackerContract $tracker
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly SecurityPolicyContract $securityPolicy,
        private readonly VerificationCommandContract $verificationCommand,
        private readonly VerificationAttemptTrackerContract $tracker,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @return array<string, mixed>
    */
    public function handle(): array
    {
        return $this->executeRateLimit($this->tracker, function() {
            $user = $this->getValidUser();

            $this->verificationCommand->createAndSaveTokenForUser($user);

            return ApiResultFormatter::success(
                'We have sent you a verification link to "' . $user->getEmail() . '".',
            );
        });
    }

    /**
     * @return User
     *
     * @throws ConflictException
    */
    private function getValidUser(): User
    {
        $user = $this->securityPolicy->checkAccess();

        if ($user->getEmailVerifiedAt() !== null) {
            throw new ConflictException('User email already verified.');
        }

        return $user;
    }
}
