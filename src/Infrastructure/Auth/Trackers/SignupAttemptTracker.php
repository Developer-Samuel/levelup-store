<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth\Trackers;

use App\Core\Ports\{
    Auth\Trackers\SignupAttemptTrackerContract,
    Shared\Proxy\SessionProxyContract
};

use App\Infrastructure\Abstract\Trackers\AbstractAttemptTracker;

class SignupAttemptTracker extends AbstractAttemptTracker implements SignupAttemptTrackerContract
{
    /**
     * @param SessionProxyContract $sessionProxy
    */
    public function __construct(SessionProxyContract $sessionProxy) {
        parent::__construct(
            sessionProxy: $sessionProxy,
            attemptsSessionKey: 'signup_attempts',
            lastAttemptSessionKey: 'last_signup_attempt',
        );
    }
}
