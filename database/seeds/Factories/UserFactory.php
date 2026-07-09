<?php

declare(strict_types=1);

namespace Database\Seeds\Factories;

use App\Core\Domain\{
    Segment\User\Entity\User,
    Segment\User\Enum\UserRole
};

trait UserFactory
{
    /**
     * @param array{
     *   email: string,
     *   first_name: string,
     *   last_name: string,
     *   password: string,
     *   role: string,
     *   email_verified_at: string
     *  } $data
     *
     * @return User
    */
    private function createUsersFromData(array $data): User
    {
        $user = new User();

        return $user
            ->setEmail($data['email'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setPassword($this->hashPassword($user, $data['password']))
            ->setRole($this->getRoleFromString($data['role']))
            ->setEmailVerifiedAt($this->parseDateTime($data['email_verified_at']));
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @return string
    */
    private function hashPassword(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    /**
     * @param string $role
     *
     * @return UserRole
     *
     * @throws \InvalidArgumentException
    */
    private function getRoleFromString(string $role): UserRole
    {
        $enum = UserRole::tryFrom($role);
        if ($enum === null) {
            throw new \InvalidArgumentException(
                sprintf('Unknown role "%s"', $role),
            );
        }

        return $enum;
    }

    /**
     * @param string $dateTime
     *
     * @return \DateTimeImmutable
    */
    private function parseDateTime(string $dateTime): \DateTimeImmutable
    {
        return new \DateTimeImmutable($dateTime);
    }
}
