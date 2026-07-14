<?php

declare(strict_types=1);

namespace App\Core\Application\Segment\User\Handler\Command;

use App\Core\Domain\{
    Segment\User\Entity\User,
    Segment\User\Payload\ChangePasswordPayload
};

use App\Core\Application\Abstract\Handler\AbstractCommandHandler;

use App\Core\Ports\{
    Security\Policy\SecurityPolicyContract,
    Segment\User\Handler\Command\ChangePasswordCommandHandlerContract,
    Segment\User\Service\Command\ChangePasswordCommandContract,
    Segment\User\Service\Query\ChangePasswordQueryContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class ChangePasswordCommandHandler extends AbstractCommandHandler implements ChangePasswordCommandHandlerContract
{
    /**
     * @param SecurityPolicyContract $securityPolicy
     * @param ChangePasswordQueryContract $changePasswordQuery
     * @param ChangePasswordCommandContract $changePasswordCommand
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly SecurityPolicyContract $securityPolicy,
        private readonly ChangePasswordQueryContract $changePasswordQuery,
        private readonly ChangePasswordCommandContract $changePasswordCommand,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @param ChangePasswordPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handle(ChangePasswordPayload $payload): array
    {
        return $this->execute(function() use ($payload) {
            $user = $this->securityPolicy->checkIfEmailVerified();

            $this->validatePasswords($payload, $user);

            $this->changePasswordCommand->changeUserPassword($user, $payload->newPassword);

            return ApiResultFormatter::success('Password successfully changed.');
        });
    }

    /**
     * @param ChangePasswordPayload $payload
     * @param User $user
     *
     * @return void
    */
    private function validatePasswords(ChangePasswordPayload $payload, User $user): void
    {
        $this->changePasswordQuery->requireOldPassword($payload, $user);
        $this->changePasswordQuery->requireNewPassword($payload, $user);
    }
}
