<?php

declare(strict_types=1);

namespace App\Core\Application\Segment\User\Handler\Command;

use App\Core\Domain\Segment\User\Payload\ProfilePayload;

use App\Core\Application\Abstract\Handler\AbstractCommandHandler;

use App\Core\Ports\{
    Security\Policy\SecurityPolicyContract,
    Segment\User\Handler\Command\UpdateProfileHandlerContract,
    Segment\User\Service\Command\ProfileCommandContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class UpdateProfileHandler extends AbstractCommandHandler implements UpdateProfileHandlerContract
{
    /**
     * @param SecurityPolicyContract $securityPolicy
     * @param ProfileCommandContract $profileCommand
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly SecurityPolicyContract $securityPolicy,
        private readonly ProfileCommandContract $profileCommand,
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
        return $this->execute(function() use ($payload) {
            $user = $this->securityPolicy->checkIfEmailVerified();

            $this->profileCommand->updateProfile($user, $payload);

            return ApiResultFormatter::success('Profile updated successfully.');
        });
    }
}
