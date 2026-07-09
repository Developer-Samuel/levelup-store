<?php

declare(strict_types=1);

namespace App\Core\Application\Auth\Service\Command;

use App\Core\Domain\Auth\ValueObject\JwtTokenObject;

use App\Core\Ports\{
    Auth\Service\Command\RefreshTokenCommandContract,
    Auth\Repository\RefreshTokenRepositoryContract,
    Gateways\External\Jwt\JwtGatewayContract
};

final readonly class RefreshTokenCommandService implements RefreshTokenCommandContract
{
    /**
     * @param JwtGatewayContract $jwtGateway
     * @param RefreshTokenRepositoryContract $refreshTokenRepository
    */
    public function __construct(
        private JwtGatewayContract $jwtGateway,
        private RefreshTokenRepositoryContract $refreshTokenRepository,
    ) {}

    /**
     * @param string $refreshToken
     *
     * @return JwtTokenObject
     *
     * @throws \RuntimeException
    */
    public function execute(string $refreshToken): JwtTokenObject
    {
        $token = $this->refreshTokenRepository->findByToken($refreshToken);

        if ($token === null || $token->isExpired()) {
            throw new \RuntimeException('Invalid or expired refresh token.');
        }

        $user = $token->getUser();

        $this->refreshTokenRepository->revoke($token);

        $newAccessToken = $this->jwtGateway->generateAccessToken($user);
        $newRefreshToken = $this->refreshTokenRepository->create($user);

        return new JwtTokenObject(
            accessToken:  $newAccessToken,
            refreshToken: $newRefreshToken->getToken(),
        );
    }
}
