<?php

declare(strict_types=1);

namespace App\Core\Application\Segment\User\Handler\Command;

use App\Core\Domain\Segment\User\Payload\ProfilePayload;

use App\Core\Application\Abstract\Handler\AbstractRateLimitHandler;

use App\Core\Ports\{
    Security\Policy\SecurityPolicyContract,
    Segment\User\Handler\Command\UpdateProfileHandlerContract,
    Segment\User\Service\Command\ProfileCommandContract,
    Segment\User\Trackers\ProfileAttemptTrackerContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class UpdateProfileHandler extends AbstractRateLimitHandler implements UpdateProfileHandlerContract
{
    /**
     * @param SecurityPolicyContract $securityPolicy
     * @param ProfileCommandContract $profileCommand
     * @param ProfileAttemptTrackerContract $tracker
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly SecurityPolicyContract $securityPolicy,
        private readonly ProfileCommandContract $profileCommand,
        private readonly ProfileAttemptTrackerContract $tracker,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @param ProfilePayload $payload
     *
     * @return array<string, mixed>
    */
    public function handle(ProfilePayload $payload): array
    {
        return $this->executeRateLimit($this->tracker, function() use ($payload) {
            $user = $this->securityPolicy->checkIfEmailVerified();

            $this->profileCommand->updateProfile($user, $payload);

            return ApiResultFormatter::success('Profile updated successfully.');
        });
    }
}
