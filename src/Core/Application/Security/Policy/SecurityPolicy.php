<?php

declare(strict_types=1);

namespace App\Core\Application\Security\Policy;

use Kit\Utils\Shared\Normalizer\StringNormalizer;

use App\Core\Domain\{
    Shared\Exception\AccessDeniedException,
    Segment\User\Entity\User,
    Segment\User\Enum\UserRole
};

use App\Core\Ports\{
    Security\Policy\SecurityPolicyContract,
    Security\Provider\SecurityProviderContract
};

final readonly class SecurityPolicy implements SecurityPolicyContract
{
    /**
     * @param SecurityProviderContract $securityProvider
    */
    public function __construct(
        private SecurityProviderContract $securityProvider,
    ) {}

    /**
     * @return User
    */
    public function checkAccess(): User
    {
        return $this->runChecks(['user']);
    }

    /**
     * @return User
    */
    public function checkIfEmailVerified(): User
    {
        return $this->runChecks(['user', 'email']);
    }

    /**
     * @return User
    */
    public function checkAdminAccess(): User
    {
        return $this->runChecks(['user', 'email', 'admin']);
    }

    /**
     * @param array<int, string> $checks
     *
     * @return User
     *
     * @throws \RuntimeException
    */
    private function runChecks(array $checks): User
    {
        $user = $this->securityProvider->getCurrentUser();
        if (!$user) {
            throw new \RuntimeException('No current user found.');
        }

        foreach ($checks as $check) {
            match ($check) {
                'user'  => $user = $this->validateUser($user),
                'email' => $user = $this->validateEmailVerified($user),
                'admin' => $user = $this->validateAdminRole($user),
                default => null,
            };
        }

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     *
     * @throws AccessDeniedException
    */
    private function validateUser(User $user): User
    {
        if (!$this->validateRoles($user, array_values(UserRole::values()))) {
            throw new AccessDeniedException('Access denied.');
        }

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     *
     * @throws \RuntimeException
    */
    private function validateEmailVerified(User $user): User
    {
        if ($user->getEmailVerifiedAt() === null) {
            throw new \RuntimeException('Email not verified.');
        }

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     *
     * @throws \RuntimeException
    */
    private function validateAdminRole(User $user): User
    {
        if (!$this->validateRoles($user, [UserRole::ADMIN->value])) {
            throw new \RuntimeException('Admin role required.');
        }

        return $user;
    }

    /**
     * @param User $user
     * @param array<int, string> $allowedRoles
     *
     * @return bool
    */
    private function validateRoles(User $user, array $allowedRoles): bool
    {
        $roles = $user->getRoles();

        foreach ($roles as $role) {
            $normalized = StringNormalizer::toLowerCase(str_replace('ROLE_', '', $role));
            if (in_array($normalized, $allowedRoles, true)) {
                return true;
            }
        }

        return false;
    }
}
