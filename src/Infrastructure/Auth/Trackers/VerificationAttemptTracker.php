<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth\Trackers;

use App\Core\Ports\{
    Auth\Trackers\VerificationAttemptTrackerContract,
    Shared\Proxy\SessionProxyContract
};

use App\Infrastructure\Abstract\Trackers\AbstractAttemptTracker;

class VerificationAttemptTracker extends AbstractAttemptTracker implements VerificationAttemptTrackerContract
{
    /**
     * @param SessionProxyContract $sessionProxy
    */
    public function __construct(SessionProxyContract $sessionProxy) {
        parent::__construct(
            sessionProxy: $sessionProxy,
            attemptsSessionKey: 'verification_attempts',
            lastAttemptSessionKey: 'last_verification_attempt',
        );
    }
}
