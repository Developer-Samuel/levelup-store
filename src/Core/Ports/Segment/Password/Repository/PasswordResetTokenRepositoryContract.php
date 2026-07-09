<?php

declare(strict_types=1);

namespace App\Core\Ports\Segment\Password\Repository;

use App\Core\Domain\{
    Segment\Password\Entity\PasswordResetToken,
    Segment\User\Entity\User
};

interface PasswordResetTokenRepositoryContract
{
    /**
     * @param string $token
     *
     * @return PasswordResetToken|null
    */
    public function findByToken(string $token): ?PasswordResetToken;

    /**
     * @param User $user
     *
     * @return void
    */
    public function removeTokensByUser(User $user): void;
}
