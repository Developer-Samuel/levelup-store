<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth\Trackers;

use App\Core\Ports\{
    Auth\Trackers\LoginAttemptTrackerContract,
    Shared\Proxy\SessionProxyContract
};

use App\Infrastructure\Abstract\Trackers\AbstractAttemptTracker;

class LoginAttemptTracker extends AbstractAttemptTracker implements LoginAttemptTrackerContract
{
    /**
     * @param SessionProxyContract $sessionProxy
    */
    public function __construct(SessionProxyContract $sessionProxy) {
        parent::__construct(
            sessionProxy: $sessionProxy,
            attemptsSessionKey: 'login_attempts',
            lastAttemptSessionKey: 'last_login_attempt',
        );
    }
}
