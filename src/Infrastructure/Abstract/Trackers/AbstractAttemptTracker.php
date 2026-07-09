<?php

declare(strict_types=1);

namespace App\Infrastructure\Abstract\Trackers;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Core\Ports\Shared\Proxy\SessionProxyContract;

abstract class AbstractAttemptTracker
{
    private const MAX_ATTEMPTS = 8;
    private const LOCKOUT_SECONDS = 60;

    public bool $tooManyAttempts = false;

    /**
     * @param SessionProxyContract $sessionProxy
     * @param string $attemptsSessionKey
     * @param string $lastAttemptSessionKey
     * @param int $maxAttempts
     * @param int $lockoutSeconds
    */
    protected function __construct(
        protected readonly SessionProxyContract $sessionProxy,
        private readonly string $attemptsSessionKey,
        private readonly string $lastAttemptSessionKey,
        private readonly int $maxAttempts = self::MAX_ATTEMPTS,
        private readonly int $lockoutSeconds = self::LOCKOUT_SECONDS,
    ) {}

    /**
     * @return void
    */
    final public function trackAttempts(): void
    {
        $session = $this->sessionProxy->get();

        $attempts = $this->getSafeIntFromSession($session, $this->attemptsSessionKey, 0);
        $lastAttempt = $this->getSafeIntFromSession($session, $this->lastAttemptSessionKey, time());

        $this->tooManyAttempts = $this->checkTooManyAttempts($attempts, $lastAttempt);

        $this->updateSession($session, $attempts, $lastAttempt);
    }

    /**
     * @param SessionInterface $session
     * @param string $key
     * @param int $default
     *
     * @return int
    */
    private function getSafeIntFromSession(SessionInterface $session, string $key, int $default): int
    {
        $value = $session->get($key, $default);

        return is_int($value) ? $value : $default;
    }

    /**
     * @param int $attempts
     * @param int $lastAttempt
     *
     * @return bool
    */
    private function checkTooManyAttempts(int $attempts, int $lastAttempt): bool
    {
        return $attempts >= $this->maxAttempts && $this->timeSinceLastAttempt($lastAttempt) < $this->lockoutSeconds;
    }

    /**
     * @param SessionInterface $session
     * @param int $attempts
     * @param int $lastAttempt
     *
     * @return void
    */
    private function updateSession(SessionInterface $session, int $attempts, int $lastAttempt): void
    {
        $isExpired = $this->timeSinceLastAttempt($lastAttempt) >= $this->lockoutSeconds;
        $newAttempts = $isExpired ? 1 : $attempts + 1;

        $session->set($this->attemptsSessionKey, $newAttempts);
        $session->set($this->lastAttemptSessionKey, time());
    }

    /**
     * @param int $lastAttempt
     *
     * @return int
    */
    private function timeSinceLastAttempt(int $lastAttempt): int
    {
        return time() - $lastAttempt;
    }
}
