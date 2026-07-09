<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Service\Command;

use App\Core\Ports\{
    Auth\Repository\RefreshTokenRepositoryContract,
    Auth\Service\Command\LogoutCommandContract
};

final readonly class LogoutCommandService implements LogoutCommandContract
{
    /**
     * @param RefreshTokenRepositoryContract $refreshTokenRepository
    */
    public function __construct(
        private RefreshTokenRepositoryContract $refreshTokenRepository,
    ) {}

    /**
     * @param string|null $refreshToken
     *
     * @return void
    */
    public function execute(?string $refreshToken): void
    {
        if ($refreshToken === null || $refreshToken === '') {
            return;
        }

        $token = $this->refreshTokenRepository->findByToken($refreshToken);

        if ($token === null) {
            return;
        }

        $this->refreshTokenRepository->revoke($token);
    }
}
