<?php

declare(strict_types=1);

namespace App\Infrastructure\Segment\Password\Repository;

use Doctrine\Persistence\ManagerRegistry;

use App\Core\Domain\Segment\Password\Entity\PasswordResetToken;

use App\Core\Ports\Segment\Password\Repository\PasswordResetTokenRepositoryContract;

use App\Infrastructure\Abstract\Repository\AbstractTokenRepository;

/**
 * @extends AbstractTokenRepository<PasswordResetToken>
*/
class PasswordResetTokenRepository extends AbstractTokenRepository implements PasswordResetTokenRepositoryContract
{
    /**
     * @param ManagerRegistry $registry
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct(
            $registry,
            PasswordResetToken::class,
        );
    }

    /**
     * @param string $token
     *
     * @return PasswordResetToken|null
    */
    public function findByToken(string $token): ?PasswordResetToken
    {
        return parent::findByToken($token);
    }

    /**
     * @return string
    */
    protected function getAlias(): string
    {
        return 'prt';
    }
}
